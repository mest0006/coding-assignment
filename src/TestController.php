<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher
{

  /**
   * Get the list of countries
   *
   * @return array
   *   The list of countries
   *
   */
  public function selectCountries()
  {
    return json_decode(parent::getRequest('getCountries'), true);
  }

  /**
   * Getting the list of universities by the id of the country 
   *
   * @return array
   *   The list of universities
   *
   */
  public function selectU($c_ID)
  {
    return json_decode(parent::getRequest('getInstitutions', array("CountryID" => $c_ID)), true);
  }


  //Renders list of universities.


  public function outputUniversities($universities, $u_ID)
  {
    $html = "";
    foreach ($universities as $unies) {
      $html .= "<div id=\"collapse" . $u_ID . "\" class=\"panel-collapse collapse\">";
      $html .= "<div class=\"card-body\">" . $unies["NameInLatinCharacterSet"] . " (" . $unies["CityName"] . ")</div>";
      $html .= "</div>";
    }
    return $html;
  }



  //Renders the data from the request of the API.
  // @return string
  //  The HTML for the view.

  public function render()
  {

    $c = $this->selectCountries();
    $html = "";
    foreach ($c as $v) {
      $universities = $this->selectU($v["ID"]);
      $num = count($universities);
      $country_n = $v["CountryName"];
      $html .= "<div class=\"card\" style=\"margin-bottom: 5px;\">";
      $html .= "<div class=\"card-header\">";
      $html .= "<a data-toggle=\"collapse\" href=\"#collapse" . $v["ID"] . "\">";
      $html .= $country_n . " (" . $num . ($num == 1 ? " university)" : " universities)");
      $html .= "</a>";
      $html .= "</div>";
      $html .= $this->outputUniversities($universities, $v["ID"]);
      $html .= "</div>";
    }

    return $html;
  }
}