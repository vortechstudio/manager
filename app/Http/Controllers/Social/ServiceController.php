<?php

namespace App\Http\Controllers\Social;

use App\Enums\Social\Post\PostTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Config\Service;
use App\Models\Social\Post\Post;
use App\Models\User\User;
use App\Notifications\Socials\NewVersionPublishedNotification;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('social.services.index');
    }

    public function show(int $serviceId)
    {
        return view('social.services.show', [
            'serviceId' => $serviceId,
            'service' => Service::with('versions', 'cercle')->find($serviceId),
        ]);
    }

    public function postVersion(int $serviceId, Request $request)
    {
        $request->validate([
            'version' => 'required',
            'title' => 'required',
            'contenue' => 'required',
        ]);

        try {
            $service = Service::find($serviceId);

            $version = $service->versions()->create([
                'version' => $request->get('version'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'contenue' => $request->get('contenue'),
                'published' => $request->has('published'),
                'publish_social' => $request->has('publish_social'),
            ]);

            if ($version->published) {
                $version->update([
                    'published_at' => now(),
                ]);
            }

            if ($version->publish_social) {
                $post = Post::create([
                    'title' => $request->get('title'),
                    'post' => $request->get('contenue'),
                    'published' => true,
                    'user_id' => User::where('email', 'maximemockelyn8@gmail.com')->first()->id,
                    'type' => PostTypeEnum::IMAGE->value,
                ]);

                $post->cercle()->attach($service->cercle->id);

                try {
                    $latest_img = \Storage::get(Service::getImage($serviceId, 'default'));
                    $image = \Storage::putFile('posts/'.now()->month.'/'.now()->day.'/', $latest_img);

                    $post->images()->create([
                        'path' => $image,
                        'post_id' => $post->id,
                    ]);
                } catch (\Exception $exception) {
                    toastr()
                        ->addError($exception->getMessage());
                }

                $version->update([
                    'publish_social_at' => now(),
                ]);

            }

            if ($version->published && $version->publish_social) {
                $users = User::notifiable()->get();
                \Notification::send($users, new NewVersionPublishedNotification($version, $service));
            }

            toastr()
                ->addSuccess('La version a bien été enregistrée');

        } catch (\Exception $exception) {
            toastr()
                ->addError($exception->getMessage());
        }

        return redirect()->back();
    }
}
