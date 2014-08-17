<?php

namespace App\Modules\Core\Assets;

use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Modules\Core\Models\Asset;

class Standard implements IAsset {

    public function put(UploadedFile $file, $path, $config)
    {
        $asset = new Asset;

        $asset->id = md5($file->getClientOriginalName() . '-' . $file->getSize() . '-' . $file->getClientMimeType() . '-' . time());
        $asset->name = $file->getClientOriginalName();
        $asset->mime = $file->getClientMimeType();

        $file->move($path . DIRECTORY_SEPARATOR . $config['path'], $asset->id);

        $asset->save();

        return $asset;
    }

    public function get($id, $path, $config)
    {
        return $path . DIRECTORY_SEPARATOR . $config['path'] . DIRECTORY_SEPARATOR . $id;
    }

    public function destroy($id, $path, $config)
    {
        $asset = Asset::find($id);

        if (empty($asset)) {
            return;
        }

        File::delete($path . DIRECTORY_SEPARATOR . $config['path'] . DIRECTORY_SEPARATOR . $asset->id);
        $asset->delete();
    }
}