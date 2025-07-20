<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    if (Auth::user()->role === 'admin') {
        return redirect()->route('books.index');
    }
    return view('public.index', ['books' => \App\Models\Book::all()]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('books', BookController::class);
    Route::get('/borrow/create', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/borrowed-books', [BorrowController::class, 'index'])->name('borrow.index');
    Route::put('/return/{id}', [BorrowController::class, 'update'])->name('borrow.return');
    Route::get('/manage-borrows', [BorrowController::class, 'manageBorrows'])->name('admin.borrows');
});

Route::post('/user/borrow/{book}', [App\Http\Controllers\BorrowController::class, 'userBorrow'])->middleware(['auth'])->name('user.borrow');
Route::get('/my-borrows', [BorrowController::class, 'myBorrows'])->middleware(['auth'])->name('user.borrows');

require __DIR__.'/auth.php';
