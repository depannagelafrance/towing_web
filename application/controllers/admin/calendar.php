<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Calendar extends Page {
    public function __construct(){
      parent::__construct();

      $calendarConfig = array(
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
      if($holidays){
          // fetch events for selected month
          $calendarData = $this->_getHolidaysForMonth($calendarMonth, $holidays);
      }
      // add calendar to view
      $this->_add_content($this->calendar->generate($calendarYear, $calendarMonth, $calendarData));
 
      $this->_render_page();
  }
  
  /**
   * Get all holidays/events for selected month so we can add them to calendar view
   * @param str $month
   * @param array of objects $holidays
   * @return array $calendarData
   */
  private function _getHolidaysForMonth($month, $holidays){
      $calendarData = array();
      foreach($holidays as $holiday){
          if(date('m', strtotime($holiday->holiday)) == $month){
              // the array key will determine what day to display the data (array value) in
              $calendarData[date('j', strtotime($holiday->holiday))] = $holiday->name;
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
        {cal_cell_content}<span class="day_listing">{day}<br /></span>&nbsp;{content}&nbsp;{/cal_cell_content}
        {cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>{content}</div>{/cal_cell_content_today}
        {cal_cell_no_content}<span class="day_listing">{day}</span>&nbsp;{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
    ';
      
     return $template;
  }  
}