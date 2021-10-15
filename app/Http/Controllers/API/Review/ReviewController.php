<?php

namespace App\Http\Controllers\API\Review;



use App\Http\Controllers\ApiController;
use App\Models\Booking;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\UrlImage;

class ReviewController extends ApiController
{
    use UrlImage;

    public function storeTourismReview(Request $request)
    {
        $tourismInfoId = $request->tourism_info_id;
        $rating = $request->rating;
        $comment = $request->comment;
        $tourismInfoName = $request->tourism_info_name;
        $bookingId = $request->booking_id;
        
        try {
            $review = new Review();
            $review->user_id =  auth()->user()->id;
            $review->tourism_info_id = $tourismInfoId;
            $review->tourism_info_name = $tourismInfoName;
            $review->rating = $rating;
            $review->comment = $comment;
            $review->status = Review::STATUS_ACTIVE;
            $review->save();


            if (!empty($request->review_images)) {
                foreach ($request->review_images as $i => $reviewIamge) {     
                    
                    $photoPath = $request->file('review_images')[$i]->store('public/review-image');
                    $photoUrl = url('/storage') . str_replace('public','', $photoPath);
                    

                    $reviewImage = new ReviewImage();
                    $reviewImage->review_id = $review->id;
                    $reviewImage->url_image =  $photoUrl;                    
                    $reviewImage->save();
                }
            }

            $booking = Booking::select('id','is_review')->findOrFail($bookingId);
            $booking->is_review = Review::STATUS_ACTIVE;
            $booking->save();

            $message = "Terimakasih telah memberi ulasan untuk pariwisata $tourismInfoName";

        } catch (Exception $e) {
            report($e);
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }

        return $this->setResponse(compact('message'));


    }

    public function showTourismReview(Request $request)
    {

        $tourismInfoId = $request->tourism_info_id;
        $rating = $request->filter_rating;
        $order = $request->filter_order == 'newer' ? 'DESC' : 'ASC';

        try {
            $reviews = Review::with('user','images')
            ->when($rating, function ($query, $rating) {
                $query->where('rating', $rating);
            })            
            ->where('tourism_info_id',$tourismInfoId)
            ->orderBy('created_at',$order)
            ->paginate(5);

        } catch (Exception $e) {
            report($e);
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }

        return $this->setResponse(compact('reviews'));

    }

    public function showUserReview(Request $request)
    {
        try {
            $reviews = Review::with('user','images')
            ->where('user_id',auth()->user()->id)->paginate(5);

        } catch (Exception $e) {
            report($e);
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }

        return $this->setResponse(compact('reviews'));

    }

   
}
