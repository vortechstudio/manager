<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\Requests\Social\PageRequest;
use App\Models\User\User;
use App\Services\Github\Issues;
use Pharaonic\Laravel\Pages\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        return view('social.pages.index');
    }

    public function create()
    {
        return view('social.pages.create', [
            'authors' => User::where('admin', true)->get(),
        ]);
    }

    public function store(PageRequest $request)
    {
        try {
            $keywords = json_decode($request->get('keywords'), true);

            $page = Page::create([
                'published' => $request->has('published'),
            ]);

            $page->translateOrNew('fr')->title = $request->get('title');
            $page->translateOrNew('fr')->description = $request->get('description');
            $page->translateOrNew('fr')->content = $request->get('content');
            $page->translateOrNew('fr')->keywords = implode(',', array_column($keywords, 'value'));

            $page->creator_id = $request->get('author');
            $page->creator_type = User::class;

            $page->save();

            toastr()
                ->addSuccess('La page a bien été enregistrée');
        } catch (\Exception $exception) {
            $issue = new Issues(Issues::createIssueMonolog('page', $exception->getMessage(), [$exception]));
            $issue->createIssueFromException();
            toastr()
                ->addError($exception->getMessage());
        }

        return redirect()->route('social.pages.index');
    }
}
