<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Carratage;
use App\Models\Interest;
use App\Models\Invoice;
use App\Models\IssuingAmount;
use App\Models\User;
use Illuminate\Http\Request;

class FetchDataController extends Controller
{
    public function articles(Request $request)
    {
        $articles = Article::all();
        if ($request->ajax()) {
            $article = Datatables()::of($articles)
                ->addColumn('action', function ($row) {
                    $btn = '<a data-id="${data.data.id }" onclick="editTodo(${data.data.id})" class="btn btn-info">Edit<i class="fa fa-sm fa-fw fa-pen"></i></a>
                       <a data-id="${data.data.id}"  onclick="deleteTodo(${data.data.id})" class="btn btn-danger">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $article;
        }
        // return response()->json([
        //     'articles' => $articles,
        // ]);
        return view('article.index', compact('article'));
    }

    public function carrat(Request $request)
    {
        $carrats = Carratage::all();
        if ($request->ajax()) {
            $carrat = Datatables()::of($carrats)
                ->addColumn('action', function ($row) {
                    $btn = '<a data-id="${data.data.id }" onclick="editTodo(${data.data.id})" class="btn btn-info">Edit<i class="fa fa-sm fa-fw fa-pen"></i></a>
                       <a data-id="${data.data.id}"  onclick="deleteTodo(${data.data.id})" class="btn btn-danger">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $carrat;
        }
        return view('carratage.index', compact('carrats'));
    }

    public function interest(Request $request)
    {
        $interests = Interest::all();
        if ($request->ajax()) {
            $interest = Datatables()::of($interests)
                ->addColumn('updated_at', function ($row) {
                    $date = date("d F Y - h:i A", strtotime($row->updated_at));
                    return $date;
                })
                ->make(true);
            return $interest;
        }
        return view('interest.index', compact('interests'));
    }

    public function issue(Request $request)
    {
        $issues = IssuingAmount::all();
        if ($request->ajax()) {
            $issue = Datatables()::of($issues)
                ->addColumn('updated_at', function ($row) {
                    $date = date("d F Y - h:i A", strtotime($row->updated_at));
                    return $date;
                })
                ->make(true);
            return $issue;
        }
        return view('issue.index', compact('issues'));
    }

    public function user(Request $request)
    {
        $users = User::all();
        if ($request->ajax()) {
            $user = Datatables()::of($users)
                ->addColumn('action', function ($row) {
                    $btn = '<a data-id="${data.data.id }" onclick="editTodo(${data.data.id})" class="btn btn-info">Edit<i class="fa fa-sm fa-fw fa-pen"></i></a>
                       <a data-id="${data.data.id}"  onclick="deleteTodo(${data.data.id})" class="btn btn-danger">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $user;
        }
        // return response()->json([
        //     'articles' => $articles,
        // ]);
        return view('user.index', compact('user'));
    }


    public function invoice(Request $request)
    {
        $invoices = Invoice::all();
        if ($request->ajax()) {
            $invoice = Datatables()::of($invoices)
                // ->addColumn('action', function ($row) {
                //     $btn = '<a data-id="${data.data.id }" onclick="editTodo(${data.data.id})" class="btn btn-info">Edit<i class="fa fa-sm fa-fw fa-pen"></i></a>
                //        <a data-id="${data.data.id}"  onclick="deleteTodo(${data.data.id})" class="btn btn-danger">Delete<i class="fa fa-sm fa-fw fa-trash"></i></a>';
                //     return $btn;
                // })
                ->rawColumns(['action'])
                ->make(true);
            return $invoice;
        }
        // return response()->json([
        //     'articles' => $articles,
        // ]);
        return view('invoice.invoice', compact('invoice'));
    }


}
