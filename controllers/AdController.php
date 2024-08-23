<?php

namespace Controller;
use App\Branch;

class AdController
{
    public function show(int $id)
    {
        /**
         * @var $id
         */

        $ad = (new \App\Ads())->getAdr($id);

        loadView('single-ad', ['ad' => $ad]);

    }

    public function create()
    {
        $title = $_POST['title'];
        $description = $_POST['desc'];
        $price = (float)$_POST['price'];
        $branch = (int)$_POST['branch_id'];
        $address = $_POST['address'];
        $rooms = (int)$_POST['rooms'];

        if ($_POST['title']
            && $_POST['desc']
            && $_POST['price']
            && $_POST['address']
            && $_POST['rooms']
        ) {
            // 1. E'lonni saqlash
            $newAdsId = (new \App\Ads())->createAds(
                $title,
                $description,
                5, // Bu yerda branch yoki user_id'ni dinamik ravishda berish kerak bo'lishi mumkin.
                1,
                $branch,
                $address,
                $price,
                $rooms
            );
            header('Location: /');

        }

        echo "Iltimos, barcha maydonlarni to'ldiring!";
    }

    public function index()
    {
        $ads = (new \App\Ads())->getAds();

        loadView('home', ['ads' => $ads]);
    }

    public function dashboard()
    {
        loadView('dashboard/dashboard');
    }
}