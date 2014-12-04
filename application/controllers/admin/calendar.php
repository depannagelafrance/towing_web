<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');
require_once(APPPATH . '/models/Calendar_model.php');

class Calendar extends Page {
    public function __construct(){
      parent::__construct();

      $calendarConfig = array(
              'start_day'    => 'monday',
              'show_next_prev' => TRUE,
              'next_prev_url' => base_url() . 'admin/calendar/display',
              'template' => $this->_calendarTemplate()
      );

      $this->load->library('towing/Admin_service');
      $this->load->library('calendar', $calendarConfig);
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->display();

    }

  /**
   * Prepare calendar for display
   * @param string $year
   * @param string $month
   */
  public function display($year = null, $month = null){
      // set default value to current year/month if none was given
      $calendarYear = ($year == null)? date('Y') : $year;
      $calendarMonth = ($month == null)? date('m') : $month;
      $calendarData = null;
      // fetch calendar data for given year
      $holidays = $this->admin_service->fetchCalendarByYear($calendarYear, $this->_get_user_token());
      if(!$holidays) {
        $holdidays = array();
      }

      // fetch events for selected month
      $calendarData = $this->_getHolidaysForMonth($calendarMonth, $holidays);

      $days_in_month = cal_days_in_month(CAL_GREGORIAN, $calendarMonth, $calendarYear);

      for($i = 1; $i <= $days_in_month; $i++)
      {

          if(!array_key_exists($i, $calendarData))
          {
            $calendarData[$i] =
                sprintf('<span class="day_listing"><a href="/admin/calendar/create/%s/%s">%s</a></span>',
                                          mktime(0, 0, 0, $calendarMonth, $i, $calendarYear),
                                          $this->_get_user_token(),
                                          $i
                                       );
          }
      }


      // add calendar to view
      $this->_add_content($this->calendar->generate($calendarYear, $calendarMonth, $calendarData));

      $this->_render_page();
  }

  public function create($timestamp, $token)
  {
    $model = new Calendar_model();

    $model->name = 'Feestdag';
    $model->date = $timestamp;

    $result = $this->admin_service->createCalendar($model, $token);

    if($result && !property_exists($result, 'statusCode'))
    {
      $this->session->set_flashdata('_INFO_MSG', sprintf("%s werd aangemaakt als feestdag", date("d/m/Y", $timestamp)));

      $year = date('Y', $timestamp);
      $month = date('m', $timestamp);

      redirect(sprintf("/admin/calendar/display/%s/%s", $year, $month));
    }
    else
    {
      die('did not work!');
    }
  }

  public function remove($id, $year, $month, $token)
  {
    $result = $this->admin_service->deleteCalendar($id, $token);

    if($result && !property_exists($result, 'statusCode'))
    {
      $this->session->set_flashdata('_INFO_MSG', 'Item werd gedelete');

      redirect(sprintf("/admin/calendar/display/%s/%s", $year, $month));
    }
    else
    {
      die('did not work!');
    }
  }

  /**
   * Get all holidays/events for selected month so we can add them to calendar view
   * @param str $month
   * @param array of objects $holidays
   * @return array $calendarData
   */
  private function _getHolidaysForMonth($month, $holidays){
      $calendarData = array();

      foreach($holidays as $holiday)
      {
          $_holiday = $holiday->holiday;
          $_month = date('m', $_holiday);
          $_day = date('j', $_holiday);
          $_year = date('Y', $_holiday);

          if($_month == $month){
              // the array key will determine what day to display the data (array value) in
              $calendarData[$_day] =
                sprintf('<span class="day_listing" style="font-size: 2em; color: #4285F5;"><a href="/admin/calendar/remove/%s/%s/%s/%s">%s</a><br /></span>&nbsp;%s&nbsp;',
                          $holiday->id,
                          $_year,
                          $_month,
                          $this->_get_user_token(),
                          $_day,
                          $holiday->name);
          }
      }


      return $calendarData;
  }

  /**
   * Template for calendar
   * @return string
   */
  private function _calendarTemplate(){
      $template = '
        {table_open}<table class="calendar">{/table_open}
        {week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
        {cal_cell_content}{content}{/cal_cell_content}
        {cal_cell_content_today}<div class="today">{content}</div>{/cal_cell_content_today}
        {cal_cell_no_content}<span class="day_listing">{day}</span>&nbsp;{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
    ';

     return $template;
  }
}
