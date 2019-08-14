<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Filters\ThreadFilters;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

		public function __construct()
		{
			// $this->middleware('auth')->only(['store', 'create']);
			$this->middleware('auth')->Except(['index', 'show']);
		}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {	
				
				// $threads = $this->getThreads($channel);
				// $threads = Thread::filter($filters)->get();
				$threads = $this->getThreads($channel, $filters);

				// If the request is looking for a json response, return the $threads as json
				if(request()->wantsJson()) {
					return $threads;
				}
		
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
			return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
				// Validation
				$this->validate($request, [
					'title' => 'required',
					'body' => 'required',

					// channel id is required, and should exists in the channels table, id column
					'channel_id' => 'required|exists:channels,id'
				]);
				
				//  dd($request->all());
				$thread = Thread::create([
					'user_id' => auth()->id(),
					'channel_id' => request('channel_id'),
					'title' => $request->input('title'),
					'body' => $request->input('body'),
				]);

				return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
      return view('threads.show', [
				'thread' => $thread,
				'replies' => $thread->replies()->paginate(20)
			]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
		}
		
		/** This is an approach for filtering threads, but as we are doing a lot of filtering, 
		* we gonna create a dedicated filter class
		 */
		// protected function getThreads(Channel $channel)
		// {
		// 		/**
		// 		* The class not found error came because route model binding was trying to get the channel
		// 		*	by his id, but we are using the slug instead (in the url)
		// 		*/
		// 		// // For this approach, we pass $channelSlug = null as a parameter
		// 		// if($channelSlug) {
		// 		// 	$channel = Channel::where('slug', $channelSlug)->first();
		// 		// 	$threads = Thread::where('channel_id', $channel->id)->latest()->get();
		// 		// }
		// 		// else {
		// 		// 	$threads = Thread::latest()->get();
		// 		// }

		// 		// In this first filter, we look for the threads but do not get them yet (->get())
		// 		if($channel->exists) {
		// 			$threads = $channel->threads()->latest();
		// 		} else {
		// 			$threads = Thread::latest();
		// 		}
				
		// 		// if request('by') we filter by the given username
		// 		if($username = request('by')) {
		// 			$user = \App\User::where('name', $username)->firstOrFail();

		// 			// filter threads by user id
		// 			$threads->where('user_id', $user->id);
		// 		}

		// 		// Get the filtered threads
		// 		$threads = $threads->get();

		// 		return $threads;
		// }

		public function getThreads(Channel $channel, ThreadFilters $filters)
		{
				$threads = Thread::latest()->filter($filters);

				if($channel->exists) {
					$threads->where('channel_id', $channel->id);
				}

				// dd($threads->toSql());

				// Filter threads using a query scope method on the thread model
				$threads = $threads->get();	

				return $threads;
		}
}
