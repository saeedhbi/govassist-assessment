<?php

namespace Packages\URLShortener\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;
use Packages\URLShortener\Models\URL;

class URLRepository implements URLRepositoryInterface
{

    public function getAll()
    {
        return URL::latest();
    }

    public function findEntityById($id)
    {
        return URL::whereId($id)->first();
    }

    public function deleteEntityById($id)
    {
        return URL::whereId($id)->delete();
    }

    public function createEntity(array $data)
    {
        return URL::create($data);
    }

    public function updateEntityById($id, array $data)
    {
        return URL::whereId($id)->update($data);
    }

    public function incrementVisits(URL $url): void
    {
        $url->visits++;
        $url->save();
    }

    public function deleteUnvisitedLinksByDate(Carbon $date)
    {
        return URL::where('visits', '=', 0)
            ->where('created_at', '<', $date)
            ->delete();
    }

    public function findBy(array $data)
    {
        return URL::where($data)->get();
    }

    public function findFirstBy(array $data)
    {
        return URL::where($data)->first();
    }
}
