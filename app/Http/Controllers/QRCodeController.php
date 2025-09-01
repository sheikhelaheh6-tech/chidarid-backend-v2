<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\QRCode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QR;

class QRCodeController extends Controller
{
    /**
     * ساخت QR برای آیتم
     */
    public function generate($itemId)
    {
        $item = Item::findOrFail($itemId);

        // اگر قبلاً ساخته شده باشه، همون رو برگردون
        $qr = QRCode::where('item_id', $item->id)->first();
        if ($qr) {
            return response()->json([
                'message' => 'QR Code already exists',
                'data' => [
                    'id'         => $qr->id,
                    'item_id'    => $qr->item_id,
                    'image_path' => asset($qr->image_path),
                    'active'     => $qr->active,
                    'created_at' => $qr->created_at,
                    'updated_at' => $qr->updated_at,
                ]
            ]);
        }

        // ساخت کد یکتا (فقط برای یکتا بودن فایل تصویر)
        $code = uniqid("item_{$item->id}_");

        // مسیر ذخیره تصویر
        $imageName = $code . '.png';
        $folder = public_path('qrcodes');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $imagePath = $folder . '/' . $imageName;

        // ساخت QR و ذخیره
        QR::format('png')
            ->size(300)
            ->generate(url("/menu/{$item->id}"), $imagePath);

        // ذخیره در دیتابیس
        $qr = QRCode::create([
            'item_id'    => $item->id,
            'code'       => $code,
            'image_path' => 'qrcodes/' . $imageName,
            'active'     => true,
        ]);

        return response()->json([
            'message' => 'QR Code created successfully',
            'data' => [
                'id'         => $qr->id,
                'item_id'    => $qr->item_id,
                'image_path' => asset($qr->image_path),
                'active'     => $qr->active,
                'created_at' => $qr->created_at,
                'updated_at' => $qr->updated_at,
            ]
        ]);
    }

    /**
     * گرفتن QR با id
     */
    public function show($id)
    {
        $qr = QRCode::findOrFail($id);

        return response()->json([
            'id'         => $qr->id,
            'item_id'    => $qr->item_id,
            'image_path' => asset($qr->image_path),
            'active'     => $qr->active,
            'created_at' => $qr->created_at,
            'updated_at' => $qr->updated_at,
        ]);
    }
}
