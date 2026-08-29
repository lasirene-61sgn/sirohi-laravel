<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Village;
use App\Models\CommitteePerson;
use App\Models\Support;
use App\Models\GalleryItem;
use App\Models\Banner;
use App\Models\Notice;
use App\Models\Event;
use App\Models\News;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if it's an admin or a committee member
        if (Auth::guard('admin')->check()) {
            $adminId = Auth::guard('admin')->id();
        } else {
            // If it's a committee member, get the admin ID from their record
            $committeeMember = Session::get('committee_member');
            if ($committeeMember) {
                $adminId = $committeeMember->admin_id;
            } else {
                // If no authenticated user, redirect to login
                return redirect()->route('admin.login');
            }
        }
        
        // Get counts for various entities
        $customersCount = Customer::count();
        $villagesCount = Village::count();
        $committeeMembersCount = CommitteePerson::count();
        $supportMembersCount = Support::count();
        $galleryItemsCount = GalleryItem::count();
        $bannersCount = Banner::count();
        $noticesCount = Notice::count();
        $eventsCount = Event::count();
        $newsCount = News::count();
        $pollsCount = Poll::count();
        
        // Get recently added customers (last 8)
        $recentCustomers = Customer::query()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        return view('admin.dashboard', compact(
            'customersCount',
            'villagesCount',
            'committeeMembersCount',
            'supportMembersCount',
            'galleryItemsCount',
            'bannersCount',
            'noticesCount',
            'eventsCount',
            'newsCount',
            'pollsCount',
            'recentCustomers'
        ));
    }
}