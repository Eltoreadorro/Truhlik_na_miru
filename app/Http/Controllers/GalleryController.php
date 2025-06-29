<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function loadMore(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 12; // Увеличили количество загружаемых фото

        $allFiles = collect(Storage::disk('public')->files('gallery'))
            ->filter(function($file) {
                return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
            })
            ->sort()
            ->values();

        $totalImages = $allFiles->count();
        $offset = ($page - 1) * $perPage;

        $newFiles = $allFiles->slice($offset, $perPage);

        $html = '';
        foreach ($newFiles as $index => $file) {
            $globalPosition = $offset + $index + 1;
            $url = Storage::url($file);
            $filename = pathinfo($file, PATHINFO_FILENAME);

            try {
                $imageSize = getimagesize(public_path('storage/' . $file));
                $isHorizontal = $imageSize && $imageSize[0] > $imageSize[1];
                $isVertical = $imageSize && $imageSize[0] < $imageSize[1];

                $colSpan = 'md:col-span-1';
                $rowSpan = 'md:row-span-1';

                if ($isHorizontal) {
                    $colSpan = 'md:col-span-2';
                } elseif ($isVertical) {
                    $rowSpan = 'md:row-span-2';
                }
            } catch (\Exception $e) {
                $colSpan = 'md:col-span-1';
                $rowSpan = 'md:row-span-1';
            }

            $html .= <<<HTML
<div class="gallery-item group cursor-pointer overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-[1.02] hover:z-10 {$colSpan} {$rowSpan}"
     data-global-pos="{$globalPosition}">
    <a href="{$url}" class="gallery-link" data-lightbox="gallery" data-title="{$filename}" data-position="{$globalPosition}">
        <div class="aspect-container bg-gray-100 overflow-hidden relative">
            <div class="image-placeholder animate-pulse bg-gray-200 absolute inset-0"></div>
            <img src="{$url}"
                 alt="{$filename}"
                 class="object-cover w-full h-full transition duration-500 group-hover:scale-105 lazyload opacity-0"
                 loading="lazy"
                 onload="this.classList.remove('opacity-0'); this.previousElementSibling.remove()">
        </div>
    </a>
</div>
HTML;
        }

        return response()->json([
            'html' => $html,
            'hasMore' => ($offset + $perPage) < $totalImages,
            'nextPage' => $page + 1,
            'totalImages' => $totalImages
        ]);
    }
}
