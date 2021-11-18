<?php

namespace Koisystems\MassEmails\Repositories\GenerateFiltersRepository;

use App\Models\Accommodation;
use App\Models\Amenity;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Region;
use App\Models\Site;

class GenerateFiltersRepository
{

  public function GenerateAllFilters(){

    $data = [

        $this->createGeneralFilter(),
        $this->createSiteFilter(),
        $this->createStatusPropertyFilter(),
        $this->createLocalizationPropertyFilter(),
        $this->createProfilePropertyFilter(),
        $this->createCaracteristicsPropertyFilter(),
        $this->createQualitativePropertyFilter(),
        $this->createAmenitiesPropertyFilter(),
    ];

    return $data;
  }


  public function createGeneralFilter(){

    $data = [
        "category"    =>  __("mass-emails::menu.general_filter"),
        "fields"    =>[
          [
            "field"       => __("mass-emails::filter.is_alep_associate"),
            "type"        =>  'select',
            "name"        =>  'is_alep_associate',
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              0 =>  __("mass-emails::filter.option_no"),
              1 =>  __("mass-emails::filter.option_yes"),
            ],
          ],
        ]
    ];

    return $data;
  }

  public function createSiteFilter(){

    $sites = Site::all();
    $fields = [];

    foreach($sites as $idx => $site){

      $fields[$idx] = [
        "field"       => $site->title,
        "type"        =>  'select',
        "name"        =>  "site_" . $site->id,
        "value"       =>  0,
        "signal"      =>  "=",
        "isVisible"   =>  false,
        "options"     =>  [

          0   =>  __("mass-emails::filter.option_pending"),
          1   =>  __("mass-emails::filter.option_approved"),
          2   =>  __("mass-emails::filter.option_reproved"),

        ]
      ];
    }

      $data = [
        "category"  =>  __("mass-emails::menu.sites_subfilter"),
        "fields"    => $fields
      ];

    return $data;

    }

    public function createStatusPropertyFilter(){


      $data = [
        "category"  => __("mass-emails::menu.situation_subfilter"),
        "fields"  => [
            [
              "field"       => __("mass-emails::filter.status"),
              "type"        =>  'select',
              "name"        =>  'status',
              "value"       =>  'inactive',
              "signal"      =>  "=",
              "isVisible"   =>  false,
              "options"     =>  [
                "inactive"  =>  __("mass-emails::filter.option_disabled"),
                "active"    =>  __("mass-emails::filter.option_active"),
                "pending"   =>  __("mass-emails::filter.option_pending"),
                "waiting"   =>  __("mass-emails::filter.option_waiting"),
              ]
            ]
        ]
      ];

      return $data;
    }

    public function createLocalizationPropertyFilter(){
      $regions = Region::all();
      $cities = Neighborhood::all();
      $districts = District::all();
      $fregs = Accommodation::select("freguesia")->groupBy("freguesia")->get();
      $regions_options = [];
      $city_options = [];
      $district_options = [];
      $freg_options = [];

      foreach($regions as $region){
        $regions_options[$region->id] = $region->title;
      }

      foreach($cities as  $city){
        $city_options[$city->id] = $city->title;
      }

      foreach($districts as $district){
        $district_options[$district->id] = $district->title;
      }

      foreach($fregs as $idx => $accommodation){
        $freg_options[$idx] = $accommodation->freguesia;
      }

      $data = [
        "category"  => __("mass-emails::menu.localization_subfilter"),
        "fields"  => [
          [
            "field"       => __("mass-emails::filter.profile"),
            "type"        =>  "select",
            "name"        =>  "environment_main",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              "historical_village"      =>  __('mass-emails::filter.environment_historical_village'),
              "historical_city_place"   =>  __('mass-emails::filter.environment_historical_city_place'),
              "mountains"               =>  __('mass-emails::filter.environment_mountains'),
              "beach"                   =>  __('mass-emails::filter.environment_beach'),
              "rural"                   =>  __('mass-emails::filter.environment_rural'),
              "urban"                   =>  __('mass-emails::filter.environment_urban')
            ]
          ],
            [
              "field"       => __("mass-emails::filter.region"),
              "type"        =>  'select',
              "name"        =>  "region_id",
              "value"       =>  0,
              "signal"      =>  "=",
              "isVisible"   =>  false,
              "options"     =>  $regions_options
            ],
            [
              "field"       => __("mass-emails::filter.city"),
              "type"        =>  'select',
              "name"        =>  "neighborhood_id",
              "value"       =>  0,
              "signal"      =>  "=",
              "isVisible"   =>  false,
              "options"     =>  $city_options,
            ],
            [
              "field"       => __("mass-emails::filter.district"),
              "type"        =>  'select',
              "name"        =>  'district_id',
              "value"       =>  0,
              "signal"      =>  "=",
              "isVisible"   =>  false,
              "options"     =>  $district_options
            ],
            [
              "field"       => __("mass-emails::filter.freg"),
              "type"        =>  'select',
              "name"        =>  "freguesia",
              "value"       =>  0,
              "signal"      =>  "=",
              "isVisible"   =>  false,
              "options"     =>  $freg_options
            ],
        ]
      ];

      return $data;
    }

    public function createProfilePropertyFilter(){

      $data = [
        "category"  =>  __("mass-emails::menu.profile_subfilter"),
        "fields"    =>  [

          [
            "field"       => __("mass-emails::filter.accessibility"),
            "type"        =>  'select',
            "name"        =>  "accommodation_acessibility",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              'no_stairs_or_stairs'   =>  __('mass-emails::filter.no_stairs_or_stairs'),
              'one_step'              =>  __('mass-emails::filter.one_step'),
              'two_steps'             =>  __('mass-emails::filter.two_steps'),
              'three_steps'           =>  __('mass-emails::filter.three_steps'),
              'more_than_three_steps' =>  __('mass-emails::filter.more_than_three_steps'),
              'access_ramp'           =>  __('mass-emails::filter.access_ramp')
            ]

          ],

          [
            "field"       => __("mass-emails::filter.animals"),
            "type"        =>  'select',
            "name"        =>  "is_pets_allowed",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              0 =>  __("mass-emails::filter.option_no"),
              1 =>  __("mass-emails::filter.option_yes"),
            ]
          ],

          [
            "field"       => __("mass-emails::filter.clean_and_safe"),
            "type"        =>  "select",
            "name"        =>  "is_clean_and_safe",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              0 =>  __("mass-emails::filter.option_no"),
              1 =>  __("mass-emails::filter.option_yes"),
            ]
          ],

          [
            "field"       => __("mass-emails::filter.kids"),
            "type"        =>  "select",
            "name"        =>  "is_suitable_for_children",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              0 =>  __("mass-emails::filter.option_no"),
              1 =>  __("mass-emails::filter.option_yes"),
            ]
          ],
        ]
      ];

      return $data;
    }

    public function createCaracteristicsPropertyFilter(){
      $options = [
        1   =>  ">",
        2   =>  "=",
        3   =>  "<"
      ];
      $data = [
        "category"  =>  __("mass-emails::menu.character_subfilter"),
        "fields"  =>  [

          [
            "field"       => __("mass-emails::filter.nr_rooms"),
            "type"        =>  'numeric',
            "name"        =>  "number_bedrooms",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  $options
          ],

          [
            "field"       => __("mass-emails::filter.capacity_rnal"),
            "type"        =>  'numeric',
            "name"        =>  "rnal_number_guests",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  $options
          ],

          [
            "field"       => __("mass-emails::filter.min_night"),
            "type"        =>  'numeric',
            "name"        =>  "min_nights_booking",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  $options
          ],

          [
            "field"       => __("mass-emails::filter.modality"),
            "type"        =>  "select",
            "name"        =>  "modality",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              1           =>  'Apartamento',
              2           =>  'Guest House + Bed&Breakfast',
              3           =>  'Hostel - Dormitório',
              4           =>  'Hostel - Quarto Privado',
              5           =>  'Moradia',
              6           =>  'Quarto Privado na casa do Proprietário',
            ]
          ],

        ]
      ];

      return $data;
    }

    public function createQualitativePropertyFilter(){
      $options = [
        1   =>  ">",
        2   =>  "=",
        3   =>  "<"
      ];

      $data = [
        "category"  =>   __("mass-emails::menu.qualitative_subfilter"),
        "fields"    =>  [

          [
            "field"       => __("mass-emails::filter.nr_photos"),
            "type"        =>  'numeric',
            "name"        =>  "nr_images",
            "value"       =>  0,
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  $options
          ],

          [
            "field"       => __("mass-emails::filter.photo_quality"),
            "type"        =>  "select",
            "name"        =>  "quality_of_images",
            "value"       =>  'outstanding',
            "signal"      =>  "=",
            "isVisible"   =>  false,
            "options"     =>  [
              "outstanding" =>  __('mass-emails::filter.outstanding_quality'),
              "good"        =>  __('mass-emails::filter.good_quality'),
              "average"     =>  __('mass-emails::filter.average_quality'),
              "poor"        =>  __('mass-emails::filter.poor_quality'),
            ]
          ],

          [
            "field"       => __("mass-emails::filter.ical"),
            "type"        =>  'select',
            "name"        =>  "ical",
            "signal"      =>  "=",
            "value"       =>  0,
            "isVisible"   =>  false,
            "options"     =>   [
              0 =>  __("mass-emails::filter.option_no"),
              1 =>  __("mass-emails::filter.option_yes"),
            ]
          ]
        ]
      ];

      return $data;
    }

    public function createAmenitiesPropertyFilter(){

      $amenities = Amenity::where("parent_id", '!=',  0)->get();
      $options = [];

      foreach($amenities as $amenity){
          $options[$amenity->id] = $amenity->title;
      }

      $data = [
        "category"  =>   __("mass-emails::menu.amenities_subfilter"),
        "fields"    =>  [
          [
            "field" =>  __("mass-emails::menu.amenities_subfilter"),
            "type"  =>  "multiselect",
            "name"  =>  "selected_amenities",
            "signal"      =>  "=",
            "value"       =>  [],
            "isVisible"   =>  false,
            "options"=> $options
          ]
        ]
      ];

      return $data;
    }

}
