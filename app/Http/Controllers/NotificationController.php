<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\SuratMasuk;
use App\SuratKeluar;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function readSurat($id)
    {
    	$notif = Auth::user()->unreadNotifications->where("id", $id)->first();
    	$notif->markAsRead();

    	if (Auth::user()->role->name == "manajer") {
    		if ($notif->type == "App\Notifications\surat_masuk") {
    			return redirect()->route('manajer.surat-masuk.show', $notif->data["id"]);
    		}
    		elseif ($notif->type == "App\Notifications\surat_keluar") {
    			return redirect()->route('manajer.surat-keluar.show', $notif->data["id"]);
    		}
    	}
    	elseif (Auth::user()->role->name == "operator") {
    		if ($notif->type == "App\Notifications\surat_keluar") {
    			return redirect()->route('operator.surat-keluar.show', $notif->data["id"]);
    		}
    	}
    }

    public function viewAll()
    {
    	
    }
}
