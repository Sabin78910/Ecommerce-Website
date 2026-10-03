<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ControllerUser extends Controller
{
    /**
     * Return up to 3 matching user pages for the typeahead.
     */
    public function pageSearch(Request $request)
    {
        $query = Str::lower($request->get('query', ''));

        $pages = [
            ['name' => 'My Dashboard',    'url' => route('user.index')],
            ['name' => 'My Orders',       'url' => route('user.orders')],
            ['name' => 'Account Details', 'url' => route('user.dashboard')],
            ['name' => 'Wishlist',        'url' => route('wishlist.index')],
            ['name' => 'Cart',            'url' => route('cart.index')],
            ['name' => 'Checkout',        'url' => route('cart.checkout')],
        ];

        $matches = array_filter($pages, fn($p) => Str::contains(Str::lower($p['name']), $query));

        return response()->json(array_values(array_slice($matches, 0, 3)));
    }

    public function index()
    {
        return view('user.index');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->paginate(12);

        return view('user.orders', compact('orders'));
    }

    public function details_about_orders($order_id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $order_id)->first();
        $orderItems = OrderItem::where('order_id', $order_id)
            ->orderBy('id', 'DESC')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();

        return view('user.details_about_order', compact('order', 'orderItems', 'transaction'));
    }

    public function order_status_update(Request $request)
    {
        $order = Order::find($request->order_id);
        $order_status = $request->order_status;

        if (!in_array($order_status, ['ordered', 'delivered', 'canceled'])) {
            return back()->withErrors(['error' => 'Invalid status value.']);
        }

        $order->canceled_date = Carbon::now();
        $order->status = (string) $order_status;
        $order->save();

        return back()->with('status', 'Order with order id '.$request->order_id.' has been canceled successfully!');
    }

    /**
     * Show the dashboard with user details.
     */
    public function dashboard()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    /**
     * Update user details like name, mobile, and email.
     */
    public function updateDetails(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email'  => 'required|email|max:255|unique:users,email,'.Auth::id(),
        ]);

        $user = User::find($request->id);

        try {
            $user->name   = $request->name;
            $user->mobile = $request->mobile;
            $user->email  = $request->email;
            $user->save();

            return back()->with('success', 'Details updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update details. Please try again.');
        }
    }

    /**
     * Update user password after checking the old password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($request->id);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update password. Please try again.');
        }
    }

    /**
     * List addresses (default first).
     */
    public function user_address()
    {
        $user = Auth::user();

        $addresses = Address::where('user_id', $user->id)
            ->orderByDesc('isdefault')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.address', [
            'user'      => $user,
            'addresses' => $addresses,
        ]);
    }

    public function create_address()
    {
        return view('user.create-address');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => ['required','string','regex:/^\+[1-9]\d{1,14}$/','max:16'],
            'zip'       => 'required|string|max:255',
            'province'  => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'address'   => 'required|string', // TEXT in DB
            'locality'  => 'required|string|max:255',
            'landmark'  => 'nullable|string|max:255',
            'district'  => 'required|string|max:255',
            'country'   => 'required|string|max:255',
            'isdefault' => 'nullable|boolean',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return back()->with('error', 'You must be logged in.')->withInput();
        }

        try {
            DB::transaction(function () use ($validated, $request, $userId) {
                $address = new Address();
                $address->user_id   = $userId;
                $address->name      = $validated['name'];
                $address->phone     = $validated['phone']; // E.164
                $address->locality  = $validated['locality'];
                $address->address   = $validated['address'];
                $address->city      = $validated['city'];
                $address->province  = $validated['province'];
                $address->district  = $validated['district'];
                $address->country   = $validated['country'];
                $address->landmark  = $validated['landmark'] ?? null;
                $address->zip       = $validated['zip'];

                // If first address, force default unless user ticked it already
                $isFirst = Address::where('user_id', $userId)->count() === 0;
                $address->isdefault = $request->boolean('isdefault') || $isFirst ? 1 : 0;

                $address->save();

                if ($address->isdefault) {
                    Address::where('user_id', $userId)
                        ->where('id', '!=', $address->id)
                        ->update(['isdefault' => 0]);
                }
            });

            return redirect()->route('user.address-details')
                ->with('success', 'Address added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Address save failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to add address. Please try again.')->withInput();
        }
    }

    public function modify_address($id)
    {
        $userId  = Auth::id();
        $address = Address::where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        return view('user.modify-address', compact('address'));
    }

    public function update_address(Request $request, $id)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => ['required','string','regex:/^\+[1-9]\d{1,14}$/','max:16'],
            'zip'       => 'required|string|max:255',
            'province'  => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'address'   => 'required|string',
            'locality'  => 'required|string|max:255',
            'landmark'  => 'nullable|string|max:255',
            'district'  => 'required|string|max:255',
            'country'   => 'required|string|max:255',
            'isdefault' => 'nullable|boolean',
        ]);

        $userId = Auth::id();

        return DB::transaction(function () use ($validated, $request, $id, $userId) {
            $address = Address::where('user_id', $userId)
                ->where('id', $id)
                ->firstOrFail();

            // Update fields
            $address->name      = $validated['name'];
            $address->phone     = $validated['phone'];
            $address->zip       = $validated['zip'];
            $address->province  = $validated['province'];
            $address->city      = $validated['city'];
            $address->address   = $validated['address'];
            $address->locality  = $validated['locality'];
            $address->landmark  = $validated['landmark'] ?? null;
            $address->district  = $validated['district'];
            $address->country   = $validated['country'];

            // Decide desired default state (don’t allow ending with zero defaults)
            $wantDefault = $request->has('isdefault')
                ? $request->boolean('isdefault')
                : (bool) $address->isdefault;

            if (!$wantDefault) {
                $hasOtherDefault = Address::where('user_id', $userId)
                    ->where('id', '!=', $address->id)
                    ->where('isdefault', 1)
                    ->exists();

                if (!$hasOtherDefault) {
                    $wantDefault = true;
                }
            }

            $address->isdefault = $wantDefault ? 1 : 0;
            $address->save();

            if ($address->isdefault) {
                Address::where('user_id', $userId)
                    ->where('id', '!=', $address->id)
                    ->update(['isdefault' => 0]);
            }

            return redirect()->route('user.address-details')
                ->with('success', 'Address updated successfully!');
        });
    }

    /**
     * Make an address the single default (atomic).
     */
    public function set_default_address($id)
{
    $userId = Auth::id();

    DB::transaction(function () use ($userId, $id) {
        // Unset ALL defaults for this user
        Address::where('user_id', $userId)->update(['isdefault' => 0]);

        // Set THIS one; 404 if it doesn't belong to the user
        $updated = Address::where('user_id', $userId)
            ->where('id', $id)
            ->update(['isdefault' => 1]);

        if ($updated === 0) {
            abort(404);
        }
    });

    // redirect AFTER the transaction has committed
    return redirect()->route('user.address-details')
        ->with('success', 'Default address updated.');
}



    /**
     * Delete address with safety rules.
     */
    public function destroy_address($id)
    {
        $userId  = Auth::id();
        $address = Address::where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $total = Address::where('user_id', $userId)->count();
        if ($total <= 1) {
            return back()->with('error', 'You must keep at least one address.');
        }

        if ((int) $address->isdefault === 1) {
            return back()->with('error', 'Cannot delete the default address. Make another address default first.');
        }

        $address->delete();
        return back()->with('success', 'Address deleted successfully.');
    }
}
