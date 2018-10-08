<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthorizationController extends Controller
{
    public function testEditComment()
    {
        // $comment = Comment::findOrFail(1);
        // if (Gate::allows('edit-comment', $comment)) {
        if (Gate::allows('edit-comment')) {
            echo "Ban co quyen chinh sua comment";
        } else {
            echo "Ban khong co quyen chinh sua comment";
        }
    }
}
