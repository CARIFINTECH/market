<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Build your CV')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection
@php
    $date = new Datetime();
    $dateMs = $date->getTimestamp();
@endphp
@section('content')
<link href="{{ asset("/css/private-profile.css?q=$dateMs") }}" rel="stylesheet" type="text/css">
<div class="body background-body">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="cvbuilder-personal-details-title">Build your CV</h2>
        <div class="steps-container">
          <ul class="steps" id="cvbuilder-steps" data-total-steps="{{count($cvSections)}}">
            @foreach($cvSections as $key => $section)
              @if($loop->index < $indexSector)
                <li class="step step-done" data-step="{{$loop->index}}">
              @elseif($loop->index == $indexSector)
                <li class="step step-current" data-step="{{$loop->index}}">
              @else
                <li class="step" data-step="{{$loop->index}}">
              @endif
                <span class="sign"></span>
                <span class="name">{{$section}}</span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="back-link">
          @if($indexSector == 0)
          <a href="/job/profile/edit/{{$profile->type}}"><i class="glyphicon glyphicon-menu-left"></i>Back</a>
          @else
          <a href="/user/cv-builder/{{array_keys($cvSections)[$indexSector - 1]}}"><i class="glyphicon glyphicon-menu-left"></i>Back</a>
          @endif
        </div>
      </div>
    </div>
    @if($slug === 'personal-details')
    <div class="row cvbuilder-personal-details">
      <div class="col-sm-12">
        <div class="section">
          <div class="row">
            <div class="col-xs-12">
              <div class="alert alert-info text-center">
                <h4>Allow companies to contact you when you apply to their jobs.</h4>
                <p>Please fill in all the blank fields.</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="section-title">
                <h2>Details about you</h2>
              </div>
            </div>
          </div>
          <form action="" method="post">
              <input name="redirect" type="hidden" value="/job/profile/edit">
              {{ csrf_field() }}
            <div class="content row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="pre-filled" for="first-name">First name</label>
                  <input class="form-control" type="text" name="first-name" id="first-name" value="{{$user->name}}">
                  <div class="validation">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="pre-filled" for="last-name">Last name (optional)</label>
                  <input class="form-control" type="text" name="last-name" id="last-name">
                  <div class="validation">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="pre-filled" for="email">Email</label>
                  <input class="form-control" type="email" name="email" id="email" value="{{$user->email}}">
                  <div class="validation">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="pre-filled" for="phone">Phone</label>
                  <input class="form-control" type="phone" name="phone" value="{{$user->phone}}">
                  <div class="validation">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-xs-12">
              <div class="section-title">
                <h2>Your address</h2>
              </div>
            </div>
          </div>
          <div class="content row">
            <div class="col-xs-12">
              <div class="address-area">
                <div class="form-group">
                  <label class="pre-filled" for="address">Address (Optional)</label>
                  <input class="form-control" type="address" name="address" value="">
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <label class="pre-filled" for="town">Town (Optional)</label>
                  <input class="form-control" type="town" name="town" value="">
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <label class="pre-filled" for="country">Country</label>
                  <select name="country" id="country" disabled class="form-control">
                    <option value="uk">United Kingdom</option>
                  </select>
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <label class="pre-filled" for="postcode">Postcode</label>
                  <input class="form-control" type="postcode" name="postcode">
                  <div class="validation"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-5 col-sm-offset-2">
              <button class="btn btn-inverse" type="button">Save and continue later</button>
            </div>
            <div class="col-xs-12 col-sm-5 continue">
              <button class="btn btn-submit" type="submit">Continue</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
    @elseif($slug === 'work-experience')
    <div class="row cvbuilder-work-experience">
      <div class="col-sm-12">
        <div class="section visual-container">
          <form action="" method="post" id="work-experience-form">
              <input name="redirect" type="hidden" value="/job/profile/edit">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-xs-12">
                  <div class="alert alert-info text-center">
                    <h4>Let companies know where you’ve worked and when.</h4>
                    <p>Please fill in all the blank fields.</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="section-title">
                    <h2>Your work experience</h2>
                  </div>
                </div>
              </div>
              <div class="form-field checkbox">
                <input type="checkbox" name="no-work-experience" id="no-work-experience">
                <label for="no-work-experience">I have no work experience</label>
              </div>
              <div class="work-experience">
                <div class="work-experience-container">
                </div>
                <div class="add-button-container text-right">
                  <button type="button" class="btn btn-secondary add-work-experience">Add work experience</button>
                </div>
              </div>
            <div class="work-experience-details" style="display: none">
                <input type="hidden" value="false" name="is-edit-experience" id="is-edit-experience">
                <input type="hidden" value="0" name="index-work-experience" id="index-work-experience">
                <div class="content row">
                  <div class="col-sm-12">
                    <h5 class="work-experience-form-title"><span>Add</span> work experience</h5>
                    <div class="job-title form-group">
                      <label for="job-title">Job title</label>
                      <input class="form-control tt-input" id="job-title" name="job-title" type="text">
                      <div class="validation"></div>
                    </div>
                    <div class="company form-group">
                      <label for="company">Company</label>
                      <input type="text" name="company" id="company" class="form-control tt-input">
                      <div class="validation"></div>
                    </div>
                    <div class="date-from group form-group date-group">
                      <label class="legend" for="date-from-month">From</label>
                      <div class="row">
                        <div class="month col-sm-6 col-xs-12">
                          <select class="form-control" id="date-from-month" name="date-from-month">
                            <option value="">Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                          </select>
                        </div>
                        <div class="year col-sm-6 col-xs-12">
                          <select class="form-control" id="date-from-year" name="date-from-year">
                            <option value="">Year</option>
                            @for($i = idate('Y'); $i > 1943; $i--)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="current-role form-group checkbox">
                      <input type="checkbox" name="is-current-role" id="is-current-role" value="true">
                      <label for="is-current-role">I currently work here</label>
                      <div class="validation"></div>
                    </div>
                    <div class="date-to form-group date-group">
                      <label class="legend" for="date-to-month">To</label>
                      <div class="row">
                        <div class="month col-sm-6 col-xs-12">
                          <select class="form-control" id="date-to-month" name="date-to-month">
                            <option value="">Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                          </select>
                        </div>
                        <div class="year col-sm-6 col-xs-12">
                          <select class="form-control" id="date-to-year" name="date-to-year">
                            <option value="">Year</option>
                            @for($i = idate('Y'); $i > 1943; $i--)
                              <option value="{{$i}}">{{$i}}</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="responsabilities form-group">
                      <label for="exampleFormControlTextarea1">What did you do there?</label>
                      <div class="value">
                        <textarea class="form-control" id="responsabilities" name="responsabilities" rows="5"></textarea>
                      </div>
                      <div class="character-count">
                        <small><strong>2000</strong> characters remaining</small>
                      </div>
                      <div class="validation">
                      </div>
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="button" class=" cancel btn btn-inline btn-link">Cancel</button>
                    <button type="button" class="btn btn-inline btn-submit confirm-work-experience-button">Confirm</button>
                  </div>
                </div>
              
            </div>
            <div class="row actions-btns-cv-builder">
              <div class="col-xs-12 col-sm-5 col-sm-offset-2">
                <button class="btn btn-inverse" type="button">Save and continue later</button>
              </div>
              <div class="continue col-xs-12 col-sm-5">
                <button class="btn btn-submit" type="submit" disabled>Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    @elseif($slug === 'qualifications')
    <div class="row cvbuilder-qualifications">
      <div class="col-sm-12">
        <div class="section visual-container">
              <div class="row">
                <div class="col-xs-12">
                  <div class="alert alert-info text-center">
                    <h4>Your qualifications let companies know more about you.</h4>
                    <p>Please enter at least one qualification.</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="section-title">
                    <h2>Your qualifications</h2>
                  </div>
                </div>
              </div>
              <div class="form-field checkbox">
                <input type="checkbox" name="no-qualifications" id="no-qualifications">
                <label for="no-qualifications">I have no qualifications</label>
              </div>
              <div class="qualifications">
                <div class="qualifications-container">
                  <div class="qualification row">
                    <div class="action edit">
                      <i class="glyphicon glyphicon-edit"></i>
                    </div>
                    <div class="action delete">
                      <i class="glyphicon glyphicon-trash"></i>
                    </div>
                    <div class="when col-xs-12 col-sm-3 text-right">
                      2012 - 2016
                    </div>
                    <div class="what col-xs-12 col-sm-9">
                      <div class="type-name">
                        <b>University degree</b>
                      </div>
                      <div class="institution">
                        University of Murcia
                      </div>
                      <div class="qualification-list">
                        <div class="qualification-item">
                          <div>
                            <span class="subject-name">Software Engineering</span>
                            <span class="grade-value">
                              <span>(Grade: 2:2)</span>
                            </span>
                          </div>
                          <div style="display: none;">
                            <div class="grade-uni">
                              <span class="grade-value-uni"> 2:2 </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="add-button-container text-right">
                  <button type="button" class="btn btn-secondary">Add qualification</button>
                </div>
              </div>
              <div class="qualification-edit" style="display: none">
                <form id="qualification-form-bulk" action="">
                  {{ csrf_field() }}
                  <input name="redirect" type="hidden" value="/job/profile/edit">
                  <input type="hidden" value="false" name="is-edit-qualification" id="is-edit-qualification">
                  <input type="hidden" value="0" name="index-edit-qualification" id="index-edit-qualification">
                  <div class="section">
                    <h5 class="qualification-form-title"><span>Add</span> qualifications</h5>
                    <div class="content row">
                      <div class="qualification-type form-group col-xs-12">
                        <label for=qualification-type>Type</label>
                        <select class="form-control" id="qualification-type" name="qualification-type">
                          <option value="">Select type</option>
                          <option value="8">A-level</option>
                          <option value="16">GCSE</option>
                          <option value="2">Master's degree</option>
                          <option value="32">Other</option>
                          <option value="4">PhD</option>
                          <option value="1">University degree</option>
                        </select>
                        <div class="validation"></div>
                      </div>
                      <div class="qualification-details" style="display: none">
                        
                          <div class="small-container col-xs-12">
                            <div class="institution form-group">
                              <label for="institution-name">Name of university or college</label>
                              <input type="text" name="institution-name" id="institution-name" class="form-control tt-input">
                              <div class="validation">
                              </div>
                            </div>
                            <div class="dates form-group">
                              <div class="row">
                                <div class="date-from col-xs-6">
                                  <label for="started-on">From</label>
                                  <select class="form-control" id="started-on" name="started-on">
                                    <option value="">Start</option>
                                    @for($i=idate('Y'); $i > 1967; $i--)
                                      <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                  </select>
                                </div>
                                <div class="date-to col-xs-6">
                                  <label for="ended-on">From</label>
                                  <select class="form-control" id="ended-on" name="ended-on">
                                    <option value="">to</option>
                                    @for($i=idate('Y'); $i > 1967; $i--)
                                      <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                  </select>
                                </div>
                                <div class="validation col-xs-12">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="subjects col-xs-12">
                            <div class="subject row">
                              <div class="subject-name form-group col-xs-12 col-sm-8">
                                <label for="subject-name">Degree</label>
                                <input type="text" name="subject-name" id="subject-name" class="form-control">
                                <div class="validation">
                                </div>
                              </div>
                              <div class="subject-grade form-group col-xs-12 col-sm-4">
                                <label for="grade-selector">Grade</label>
                                <select class="form-control" name="grade-selector" id="grade-selector">
                                  <option value="">Select</option>
                                  <option value="1">First</option>
                                  <option value="2">2:1</option>
                                  <option value="3">2:2</option>
                                  <option value="4">Third</option>
                                  <option value="5">Pass</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="other col-sm-9 col-xs-12" style="display: none">
                            <label for="grade-description">Grade (Optional)</label>
                            <input type="text" name="grade-description" id="grade-description" class="form-control">
                            <div class="validation"></div>
                          </div>
                          <div class="col-xs-12 text-right">
                            <button type="button" class=" cancel btn btn-inline btn-link">Cancel</button>
                            <button type="submit" class="btn btn-inline btn-submit confirm-work-experience-button">Confirm</button>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  </form>
              </div>
              <div class="row actions-btns-cv-builder">
                <div class="col-xs-12 col-sm-5 col-sm-offset-2">
                  <button class="btn btn-inverse" type="button">Save and continue later</button>
                </div>
                <div class="continue col-xs-12 col-sm-5">
                  <button class="btn btn-submit" type="submit" disabled>Continue</button>
                </div>
              </div>
          </div>
        </div>
      </div>
    @elseif($slug === 'personal-statement')
    <div class="row cvbuilder-qualifications">
      <div class="col-sm-12">
        <div class="section visual-container">
          <div class="row">
            <div class="col-xs-12">
              <div class="alert alert-info text-center">
                <h4>Adding a personal statement can strengthen your CV.</h4>
                <p>This section is optional.</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="section-title">
                <h2>Personal statement</h2>
              </div>
              <div class="form-group">
                <p>Try and answer the following questions: who you are, what you can offer, and what you’re aiming for in your career.</p>
                <textarea class="form-control" rows="15" id="statement" name="statement"></textarea>
                <div class="validation">
                </div>
              </div>
              <div class="update-foem-control row">
                <p class="limit col-xs-12 col-sm-6">
                  <strong>2000</strong>
                  <span>characters</span>
                  remaining
                </p>
              </div>
            </div>
          </div>
          <div class="row actions-btns-cv-builder">
            <div class="col-xs-12 col-sm-5 col-sm-offset-2">
              <button class="btn btn-inverse" type="button">Preview</button>
            </div>
            <div class="continue col-xs-12 col-sm-5">
              <button class="btn btn-submit" type="submit">Save and finish</button>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
<script>
  $('.continue .btn-submit').click(function(e){
    e.preventDefault();
    @if($indexSector < count($cvSections) - 1)
      window.location.href = '/user/cv-builder/{{array_keys($cvSections)[$indexSector + 1]}}';
    @else
      window.location.href = '/job/profile/edit/general';
    @endif
  })
  $('.add-work-experience').click(function(){
    $(this).parent().hide();
    $('#no-work-experience').parent().hide();
    $('.work-experience-details').show();
  });
  $('.add-button-container button').click(function(){
    $(this).parent().hide();
    $('.qualification-edit').show();
    $('#no-qualifications').parent().hide();
  });
  $('.cancel').click(function(){
    $('.add-button-container').show();
    //work
    $('.work-experience-details').hide();
    $('#no-work-experience').parent().show();
    //qualifications
    $('.qualification-edit').hide();
    $('#no-qualifications').parent().show();
    $('#qualification-form-bulk')[0].reset();
  });
  $('#is-current-role').change(function(){
    var dateTo = $('.date-to');
    if(this.checked){
      dateTo.hide();
    }
    else{
      dateTo.show();
    }
  });
  $('#qualification-type').change(function(){
    $('#qualification-type option:selected').each(function(){
      var val = $(this).val();
      var container = $('.qualification-details');
      if(val != ''){
        if(val == '32'){
          setOtherGradeForm();
        }
        else if(val == '8'){
          setAGradeForm();
        }
        else if(val == '16'){
          setOtherGCSEForm();
        }
        else if(val == '2' || val == '4'){
          setMasterGradeForm();
        }
        else{
          setDegreeGradeForm();
        }
        container.show();
      }else{
        container.hide();
      }
    });
  });
  $('#no-work-experience').change(function(){
    var button = $('.continue button');
    if(this.checked){
      button.removeAttr('disabled');
    }
    else{
      button.prop("disabled", true);
    }
  })
  $('.confirm-work-experience-button').click(function(){
      var jobTitle = $('#job-title').val();
      $('#job-title').val('');
      var company = $('#company').val();
      $('#company').val('');
      var dateFrom = $('#date-from-month').val() + '/' + $('#date-from-year').val();
      $('#date-from-month').val('');
      $('#date-from-year').val('');
      var dateTo = "";
      if($('#is-current-role').prop('checked')){
        dateTo = "Present";
      }
      else{
        dateTo = $('#date-to-month').val() + '/' + $('#date-to-year').val();
      }
      var responsabilities = $('#responsabilities').val();
      $('#responsabilities').val('');
      var text = '<div class="action delete">\n'
                    +  '<i class="glyphicon glyphicon-trash"></i>\n'
                    + '</div>\n'
                    + '<div class="action edit">\n'
                    +  '<i class="glyphicon glyphicon-edit"></i>\n'
                    + '</div>\n'
                    + '<div class="when col-xs-12 col-sm-3 col-md-2 text-right">\n'
                    + dateFrom + ' - ' + dateTo + '\n'
                    + '</div>\n'
                    + '<div class="what col-xs-12 col-sm-9 col-md-10">\n'
                    + '<div class="title">' + jobTitle + '</div>\n'
                    + '<div class="company">' + company + '</div>\n'
                    + '<div class="description hidden-xs">\n'
                    +  responsabilities +'\n'
                    + '</div>'
                    + '</div>\n';
      if(!isEditExperience()){
        text = '<div class="work row">\n' + text + '</div>';
        $('.work-experience-container').append(text);
     }
     else{
      setEditExperience('false');
      var index = $('#index-work-experience').val() - 1;
      $('#index-work-experience').val('0');
      $('.work-experience-container .work').eq(index).html(text); 
     } 
      $('.work-experience-details').hide();
      $('#no-work-experience').parent().hide();
      
      $('.add-button-container').show();
      $('.continue button').removeAttr('disabled');
  });
  $(document).on('click', '.action.delete', function(){
    $(this).parent().remove();
    if($('.work').length == 0){
      $('#no-work-experience').parent().show();
      $('.continue button').prop("disabled", true);
    }
  })
  $(document).on('click', '.action.edit', function(){
    var what = $(this).siblings('.what');
    var when = $(this).siblings('.when').text().split('-');
    if($(this).closest('.qualification')){
      populateQualificationForm(what, when);
      $('.qualification-edit').show();
      $('.qualification-details').show();
      setEditQualification('true');
      setQualificationIndex($('.qualification').index($(this).parent()));
      //TODO add index
    }
    else{
      $('.work-experience-details').show();
      $('.add-work-experience').parent().hide();
      $('#no-work-experience').parent().hide();
      $('#index-work-experience').val($('.work').index($(this).parent()));
      $('#is-edit-experience').val('true');
      var dateFrom = when[0].split('/');
      console.log(dateFrom);
      var dateTo = dateTo = when[1].split('/');
      if(dateTo.length > 1){
        $('#date-to-month').val(dateTo[0].trim());
        $('#date-to-year').val(dateTo[1].trim());
      }
      else{
        $('#is-current-role').prop('checked', true);
      }
      $('#date-from-month').val(dateFrom[0].trim());
      $('#date-from-year').val(dateFrom[1].trim());
      $('#job-title').val(what.find('.title').text());
      $('#company').val(what.find('.company').text())
      $('#responsabilities').val(what.find('.description').text());
    }
  });
  $('#qualification-form-bulk').submit(function(e){
    e.preventDefault();
    var type = $('#qualification-type option:selected').text();
    var institution = $('#institution-name').val();
    var startedOn = $('#started-on').val();
    var endedOn = $('#ended-on').val();
    var subjectName = $('#subject-name').val();
    if(type == '32'){
      var gradeDescription = $('#grade-description').text();
    }else{
      var gradeSelector = $('#grade-selector option:selected').text();
      var idGradeSelector = $('#grade-selector').val();
    }
    var text = '<div class="action edit">'
                      +' <i class="glyphicon glyphicon-edit"></i>'
                      +'</div>'
                      +'<div class="action delete">'
                      + '<i class="glyphicon glyphicon-trash"></i>'
                      +'</div>'
                      +'<div class="when col-xs-12 col-sm-3 text-right">'
                      + startedOn + ' - ' + endedOn
                      +'</div>'
                      +'<div class="what col-xs-12 col-sm-9">'
                      +  '<div class="type-name">'
                      +    '<b>' + type + '</b>'
                      +  '</div>'
                      + '<div class="institution">'
                      + institution 
                      +  '</div>'
                      +  '<div class="qualification-list">'
                      +    '<div class="qualification-item">'
                      +      '<div>'
                      +        '<span class="subject-name">Software Engineering</span>'
                      +        '<span class="grade-value">'
                      +          '<span>(Grade: ' + gradeSelector +')</span>'
                      +        '</span>'
                      +      '</div>'
                      +      '<div style="display: none;">'
                      +        '<div class="grade-uni">'
                      +          '<span class="grade-value-uni">' + gradeSelector + '</span>'
                      +        '</div>'
                      +      '</div>'
                      +    '</div>'
                      +  '</div>'
                      +'</div>\n';
    if(!isEditQualification()){
      text = '<div class="qualification row">\n'+ text +'</div>\n';
      $('.qualifications-container').append(text);
    }else{
      var index = $('#index-edit-qualification').val();
      $('#index-edit-qualification').val('0');
      $('.qualifications-container .qualification').eq(index).html(text);
      setEditQualification('false');
      setQualificationIndex('0');
    }
    $('.qualification-edit').hide();
    $(this)[0].reset();
  });
  function isEditExperience(){
    return ($('#is-edit-experience').val() === 'true');
  }
  function isEditQualification(){
    return ($('#is-edit-qualification').val() === 'true'); 
  }
  function setEditQualification(value){
    $('#is-edit-qualification').val(value);
  }
  function setEditExperience(value){
    $('#is-edit-experience').val(value);
  }
  function setQualificationIndex(value){
    $('#index-edit-qualification').val(value);
  }
  function setOtherGradeForm(){
    $('[for="subjet-name"]').text('Qualification');
    $('[for="institution-name"]').text('Name of awarding body');
    $('.subject-grade').hide();
    $('.other').show();
  }
  function setOtherGCSEForm(){
    $('[for="subjet-name"]').text('Subject');
    $('[for="institution-name"]').text('School or college');
    var text = '<option value="">Select</option>\n<option value="9">A*</option>\n<option value="10">A</option>\n<option value="11">B</option>\n<option value="12">C</option>\n<option value="13">D</option>\n<option value="14">E</option>\n<option value="16">F</option>\n<option value="17">G</option>\n<option value="19">9</option>\n<option value="20">8</option>\n<option value="21">7</option>\n<option value="22">6</option>\n<option value="23">5</option>\n<option value="24">4</option>\n<option value="25">3</option>\n<option value="26">2</option>\n<option value="27">1</option>';
    $('#grade-selector').html(text);
    $('.subject-grade').show();
    $('.other').hide();
  }
  function setAGradeForm(){
    $('[for="subjet-name"]').text('Subject');
    $('[for="institution-name"]').text('School or college');
    var text = '<option value="">Select</option>\n<option value="9">A*</option>\n<option value="10">A</option>\n<option value="11">B</option>\n<option value="12">C</option>\n<option value="13">D</option>\n<option value="14">E</option>';
    $('#grade-selector').html(text);
    $('.subject-grade').show();
    $('.other').hide();
  }
  function setMasterGradeForm(){
    $('[for="subjet-name"]').text('Degree');
    $('[for="institution-name"]').text('Name of university or college');
    var text = '<option value="">Select</option><option value="6">Distinction</option><option value="7">Merit</option><option value="5">Pass</option>';
    $('#grade-selector').html(text);
    $('.subject-grade').show();
    $('.other').hide();
  }
  function setDegreeGradeForm(){
    $('[for="subjet-name"]').text('Degree');
    $('[for="institution-name"]').text('Name of university or college');
    var text = '<option value="">Select</option><option value="1">First</option><option value="2">2:1</option><option value="3">2:2</option><option value="4">Third</option><option value="5">Pass</option>';
    $('#grade-selector').html(text);
    $('.subject-grade').show();
    $('.other').hide();
  }
  function populateQualificationForm(what, when){
    var typeGrade = $('.type-name b').text().replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');
    console.log(typeGrade);
    $('#qualification-type option').each(function(){
      if($(this).text() == typeGrade){
        $(this).prop('selected', true);
      }
    });
    $('#institution-name').val(what.find('.institution').text().replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, ''));
    $('#started-on').val(when[0].trim());
    $('#ended-on').val(when[1].trim());
    $('#subject-name').val(what.find('.subject-name').text().replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, ''));
    var gradeSelector = what.find('.grade-value-uni').text().replace(/([\ \t]+(?=[\ \t])|^\s+|\s+$)/g, '');
    $('#grade-selector option').each(function(){
      if($(this).text() == gradeSelector){
        $(this).prop('selected', true);
      }
    });
  }
  
</script>
@endsection