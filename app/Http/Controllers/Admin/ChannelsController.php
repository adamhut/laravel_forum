<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChannelsController extends Controller
{
    /**
     * Show all channels.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::withoutGlobalScopes()->orderBy('name', 'asc')->withCount('threads')->get();

        return view('admin.channels.index', compact('channels'));
    }

    /**
     * Show the form to create a new channel.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.channels.create', ['channel' => new Channel]);
    }

    /**
     * Store a new channel.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $channel = Channel::create(
            request()->validate([
                'name' => 'required|unique:channels',
                'description' => 'required',
            ])
        );

        Cache::forget('channels');
        if (request()->wantsJson()) {
            return response($channel, 201);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been created!');
    }

    public function edit($channel)
    {
        $channel = Channel::where('slug', $channel)->firstOrFail();

        return view('admin.channels.edit', compact('channel'));
    }

    /**
     * Update an existing channel.
     *
     * @return \Illuminate\
     */
    public function update(Channel $channel)
    {
        $channel->update(
            request()->validate([
                'name' => ['required', Rule::unique('channels')->ignore($channel->id)],
                'description' => 'required',
                'archived' => 'required|boolean',
            ])
        );
        cache()->forget('channels');
        if (request()->wantsJson()) {
            return response($channel, 200);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been updated!');
    }
}
