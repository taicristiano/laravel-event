<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Comment;

class AuthorizationController extends Controller
{
    public function tesGate()
    {
        // $comment = Comment::findOrFail(1);
        // if (Gate::allows('edit-comment', $comment)) {
        if (Gate::allows('edit-comment')) {
            echo "Ban co quyen chinh sua comment";
        } else {
            echo "Ban khong co quyen chinh sua comment";
        }

        // Gate::before(function ($user, $ability) {
        //     if ($user->isSuperAdmin()) {
        //         return true;
        //     }
        // });
    }

    public function testPolicy($id)
    {
        $user = \Auth::user();
        $comment = Comment::findOrFail($id);
        if ($user->can('view', $comment)) {
            dump(1);
        }
        if ($user->cant('view', $comment)) {
            dump(2);
        }
        if ($this->authorize('view', $comment)) {
            dump(3);
        }
        dd(2333);

    }
}
