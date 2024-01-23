<?php namespace LivestudioDev\Lscartreviews\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use LivestudioDev\Lscartreviews\Models\Review;

class Reviews extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item2', 'reviews');
    }

    public function onAcceptReview()
    {
        $review = Review::find(\Input::get('id'));
        $review->accepted = 1;
        $review->save();
        \Flash::success('A véleményt sikeresen jóváhagyta!');
    }

    public function onAcceptBulkReviews()
    {
        $checked = \Input::get('checked');
        foreach ($checked as $reviewid) {
            $review = Review::find($reviewid);
            $review->accepted = 1;
            $review->save();
        }
        \Flash::success('A véleményeket sikeresen jóváhagyta!');
    }

    public function onShowText()
    {
        $review = Review::find(\Input::get('id'));
        $review->showtext = 1;
        $review->save();
    }

    public function onShowTextBulk()
    {
        $checked = \Input::get('checked');
        foreach ($checked as $reviewid) {
            $review = Review::find($reviewid);
            $review->showtext = 1;
            $review->save();
        }
    }
}