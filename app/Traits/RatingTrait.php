<?php

namespace App\Traits;

trait RatingTrait
{
    /**
     * @param $rating
     * @return string
     */
    private function getRating($rating): string
    {
        $style = "<style>
                .rating-stars,
                .rating-stars-in {
                    display: inline-block;
                }
                .rating-stars-in-front,
                .rating-stars-in-back {
                    display: inline-flex;
                }
                .rating-stars-in-front {
                    position: absolute;
                    z-index: 2;
                    overflow: hidden;
                    top: 3px;
                    left: 0;
                }
                </style>";
        $html  = '<div class="rating-stars position-relative" title="' . $rating . ' out of 5">';
        $html  .= '<div class="rating-stars-in">';
        $html  .= '<div class="rating-stars-in-back text-secondary">'
                  . $this->getStars() . '</div>';
        $html  .= '<div class="rating-stars-in-front text-primary" style="width: ' . $rating * 20 . '%;">'
                  . $this->getStars() . '</div>';
        $html  .= '</div>';
        $html  .= '</div>';
        $html  .= $style;

        return $html;
    }

    /**
     * @return string
     */
    private function getStars(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<span class="la la-star"></span>';
        }

        return $html;
    }
}
