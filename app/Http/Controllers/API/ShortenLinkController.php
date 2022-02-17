<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;

class ShortenLinkController extends Controller
{
    const ALPHABET = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    const BASE = 64;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "baslkdjaskldjasdl";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->validate(request(), [
            'name' => ['required', 'unique:links'],
        ]);

        $link = request()->input('name');

        $id = 0;
        $last = Link::latest();
        if ($last) {
            $id = $last->value("id") + 1;
        }

        $shortened = $this->encode($id);
        $userId = Auth::id();

        Link::create([
            "name" => $link,
            "shorten" => $shortened,
            "user_id" => $userId
        ]);

        return redirect()->back()->with("link", $shortened);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // return view('test')->with('id', $id);

        $link = Link::where("shorten", $id)->get();
        // dd($link->last()->name);

        if ($link->isEmpty()) {
            return redirect()->to("home");
        }

        $fullLink = "https://" . $link->last()->name;

        // dd($fullLink);

        return redirect()->to($fullLink);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function encode($number)
    {
        if ($number === 0) {
            return $this::ALPHABET[0];
        }
        $temp = $number;
        $s = "";
        while ($temp > 0) {
            $s .= $this::ALPHABET[$temp % $this::BASE];
            $temp = (int) $temp / $this::BASE;
        }

        return strrev($s);
    }

    private function decode($string)
    {
        $i = 0;
        for ($index = 0; $index < strlen($string); $index++) {
            $i = ($i * $this::BASE) + strpos($this::ALPHABET, substr($string, $index));
        }
        return $i;
    }
}
