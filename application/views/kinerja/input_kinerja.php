<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- third party css -->
    <link href="<?php echo base_url();?>assets/new/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->


    <style>

    #ajaxlist_aktifitas,  #list_keterangan{
        border: 1px solid #EEE;
        padding: 10px;
        max-height: 300px;
        max-width: 85%;
        overflow-y: scroll;
        display: none;
        position: absolute;
        background-color: #FFF;
        z-index: 99;
    }



    .list-aktifitas, .list-keterangan{
        border-bottom: 1px solid #EEE;
        padding: 5px;
        cursor: pointer;
    }

    .list-aktifitas:hover{
        color: orangered;
    }


    </style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>

                    <!-- Start Content-->
                    <div class="container-fluid">


                        <?php
                            $message = $this->session->flashdata('message');
                            $periode = '2025-01';

                            $dataAktifitas = array();


                            $totalMenitAktifitas = 0;

                            $totalAktifitas  = 0;
                            $jmlPending = 0;
                            $jmlMentPending = 0;

                            $jmlApprove = 0;
                            $jmlMentApprove = 0;

                            $jmlReject = 0;
                            $jmlMentReject = 0;

                            foreach ($dataAktifitasPegawai as $aktifitas) {
                              $tgl = $aktifitas->tgl;
                              $jam_mulai = $aktifitas->jam_mulai;
                              $jam_selesai = $aktifitas->jam_selesai;
                              $total = $aktifitas->total;
                              $status = $aktifitas->status;


                              $periodeAktifitas = date('Y-m', strtotime($tgl));

                              if($periode==$periodeAktifitas){
                                $totalAktifitas  = $totalAktifitas+1;


                                if($status==0){

                                  $jmlPending = $jmlPending+1;
                                  $jmlMentPending = $jmlMentPending+ $total ;

                                }else if($status==1){
                                  $jmlApprove = $jmlApprove +1;
                                  $jmlMentApprove =  $jmlMentApprove + $total;
                                }else{
                                  $jmlReject = $jmlReject+1;
                                  $jmlMentReject =  $jmlMentReject+$total;
                                }

                                $totalMenitAktifitas =  $totalMenitAktifitas + $total;

                              }


                                if($status==0){
                                  $color = 'bg-warning';
                                }else if($status==1){
                                  $color = 'bg-success';
                                }else{
                                  $color = 'bg-danger';
                                }





                                $dataAktifitas[] = array(
                                  'id'=> $aktifitas->id,
                                  'title' => $total,
                                  'start' => $tgl.' '.date('H:i:s', strtotime($jam_mulai)),
                                  'className' =>$color
                                );


                            }


                            $json_aktifitas = json_encode($dataAktifitas);

                          //  echo $json_aktifitas;

                                      //print_array($dataAktifitasPegawai);
                        ?>



                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item ">Kinerja</li>
                                              <li class="breadcrumb-item active">Input Aktifitas</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Input Aktifitas</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                             <div class="row">
                                              <div class="col-12">

                                                  <div class="card">
                                                      <div class="card-body">
                                                          <div class="row">
                                                              <div class="col-lg-3">
                                                                  <div class="d-grid">
                                                                      <button class="btn btn-lg font-16 btn-danger" id="btn-new-event"><i class="mdi mdi-plus-circle-outline"></i> Create New
                                                                          Event</button>
                                                                  </div>
                                                                  <div id="external-events" class="m-t-20">
                                                                      <br>
                                                                      <p class="text-muted">Drag and drop your event or click in the calendar
                                                                      </p>
                                                                      <div class="external-event bg-success-lighten text-success" data-class="bg-success">
                                                                          <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>New
                                                                          Theme Release
                                                                      </div>
                                                                      <div class="external-event bg-info-lighten text-info" data-class="bg-info">
                                                                          <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>My
                                                                          Event
                                                                      </div>
                                                                      <div class="external-event bg-warning-lighten text-warning" data-class="bg-warning">
                                                                          <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Meet
                                                                          manager
                                                                      </div>
                                                                      <div class="external-event bg-danger-lighten text-danger" data-class="bg-danger">
                                                                          <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Create
                                                                          New theme
                                                                      </div>
                                                                  </div>


                                                              </div> <!-- end col-->



                                                              <div class="col-lg-9">
                                                                  <div class="mt-4 mt-lg-0">
                                                                      <div id="calendar"></div>
                                                                  </div>
                                                              </div> <!-- end col -->

                                                          </div> <!-- end row -->
                                                      </div> <!-- end card body-->
                                                  </div> <!-- end card -->


                                              </div>
                                              <!-- end col-12 -->
                                          </div> <!-- end row -->


                    </div> <!-- container -->


                    <!-- Add New Event MODAL -->
                    <div class="modal fade" id="event-modal" tabindex="-1">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <form class="needs-validation" method="post" action="<?php echo base_url();?>kinerja/insert_aktifitas_v2" name="event-form" id="form-event" novalidate="">
                                    <div class="modal-header py-3 px-4 border-bottom-0">
                                        <h5 class="modal-title" id="modal-title">Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-4 pb-4 pt-0">
                                        <div class="row">

                                              <div class="col-12 mb-2 text-center">

                                                 <h4><span class="badge badge-info-lighten" id="title_date">Rabu, 23 Feb 2025</span></h4>

                                                 <div class="row">
                                                    <div class="col-md-6">
                                                      Absen Masuk : <br> <span class="text-success fw-bold" id="absen_masuk">00 </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        Absen Keluar :  <br>  <span class="text-danger fw-bold"  id="absen_pulang">00 </span>
                                                    </div>

                                                 </div>


                                              </div>
                                              <div class="col-6 mb-2">

                                                  <input type="hidden"  name="tanggal" id="tanggal" value="" class="form-control">
                                              </div>

                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="control-label form-label">Nama Aktifitas</label>
                                                    <input class="form-control" placeholder="cari aktifitas" type="text" name="aktifitas" id="aktifitas" required="">
                                                      <div id="ajaxlist_aktifitas"></div>
                                                    <div class="invalid-feedback">Please provide a valid event name</div>
                                                </div>
                                            </div>


                                            <div class="col-6 mb-2">
                                                <label for="jam_mulai" class="inline-block mb-2 text-base font-medium">Jam Mulai </label>
                                                <input type="text"  name="jam_mulai" id="jam_mulai" value="06:00" class="time jam_mulai form-control">
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="jam_selesai" class="inline-block mb-2 text-base font-medium">Jam Selesai</label>
                                                <input type="text" name="jam_selesai" id="jam_selesai" value="07:00" class="time durationNegativeMinMax form-input-kinerja form-control">
                                            </div>


                                            <div class="col-6 mb-2">
                                                <label for="waktu_efektif" class="inline-block mb-2 text-base font-medium"> Waktu Efektif  </label> <span class="text-danger">*</span></label>
                                                <input  type="text" id="waktu_efektif" name="waktu_efektif" value=""  class="form-control">
                                            </div>
                                          <div class="col-6 mb-2">
                                                <label for="volume" class="inline-block mb-2 text-base font-medium">Volume</label><span class="text-danger">*</span></label>
                                                <input  type="text" id="volume" name="volume" required  autocomplete="off"  value="" class="form-control">
                                            </div>


                                            <div class="col-12 mb-2">

                                                <label for="keterangan" class="inline-block mb-2 text-base font-medium">Keterangan</label>
                                                <textarea name="keterangan" id="keterangan" class="form-control"  rows="2" cols="10" wrap="soft"></textarea>
                                                  <div id="list_keterangan"></div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" value="" class="btn btn-danger" id="btn-delete-event">Delete</button>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- end modal-content-->
                        </div> <!-- end modal dialog-->
                    </div>
                    <!-- end modal-->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->
        <?php $this->load->view('layout/section/theme-setting');?>

        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>



         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->


        <!-- third party js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-clock-timepicker.js"></script>
        <!-- third party js ends -->

        <!-- demo app -->


    <script type="text/javascript">

      $(document).ready(function(){

         $("#ajaxlist_aktifitas").hide();


           //klik di inputan untuk mencari kegiatan yang biasa di input oleh pegawai tersebut
           $("#aktifitas").click(function(){

             var keyword = $(this).val();
             $("#ajaxlist_aktifitas").show();
                 $.ajax({
                     type:"POST",
                     dataType:"html",
                     url:"<?php echo base_url();?>kinerja/ajaxGetFrequentAktifitas",
                     data:"keyword="+keyword,
                     success:function(msg){
                         $("#ajaxlist_aktifitas").html(msg);
                     }

                 });
             });

             $("#aktifitas").keyup(function(){
                     var keyword = $(this).val();
                     $("#ajaxlist_aktifitas").show();
                         $.ajax({
                             type:"POST",
                             dataType:"html",
                             url:"<?php echo base_url();?>kinerja/ajaxSearchAktifitas",
                             data:"keyword="+keyword,
                             success:function(msg){
                                 $("#ajaxlist_aktifitas").html(msg);
                             }

                         });


                 });



                 $('.jam_mulai').clockTimePicker({
                     precision: 5
                     });

                 $('.durationNegativeMinMax').clockTimePicker({
                     duration: true,
                     precision: 5
                     });



                     $("#jam_mulai").change(function() {
                             var jam_mulai = $(this).val();

                             $("#jam_selesai").val(jam_mulai);
                             $('.durationNegativeMinMax').clockTimePicker({
                                 duration: true,
                                 minimum: jam_mulai,
                                 maximum: '23:59',
                                 precision: 5
                             });

                           $("#jam_selesai").focus();
                     });


                     $("#jam_selesai").change(function() {
                             waktu_efektif = $("#waktu_efektif").val();
                             var jam_mulai = $("#jam_mulai").val();
                             var jam_selesai = $(this).val();
                             $(".loader").show();
                             $.ajax({
                                 type: "POST",
                                 dataType: "html",
                                 url: "<?php echo base_url();?>kinerja/hitung_volume",
                                 data: "waktu_efektif=" + waktu_efektif + "&jam_mulai=" + jam_mulai + "&jam_selesai=" + jam_selesai,
                                 success: function(msg) {
                                 $("#volume").val(msg);
                                 $(".loader").fadeOut();
                                 }
                             });
                     });


      });

      !function(l){"use strict";function e()
        {
          this.$body=l("body"),
          this.$modal=new bootstrap.Modal(document.getElementById("event-modal"),{backdrop:"static"}),
          this.$calendar=l("#calendar"),
          this.$formEvent=l("#form-event"),
          this.$btnNewEvent=l("#btn-new-event"),
          this.$btnDeleteEvent=l("#btn-delete-event"),
          this.$btnSaveEvent=l("#btn-save-event"),
          this.$modalTitle=l("#modal-title"),
          this.$dateActivity=l("#tanggal"),
          this.$dateInfo=l("#title_date"),
          this.$calendarObj=null,
          this.$selectedEvent=null,
          this.$newEventData=null
        }

        e.prototype.onEventClick=function(e){

          this.$formEvent[0].reset(),
          this.$formEvent.removeClass("was-validated"),
          this.$newEventData=null,
          this.$btnDeleteEvent.show(),
          this.$modalTitle.text("Edit Event"),
          this.$modal.show(),
          this.$selectedEvent=e.event,


            $("#btn-delete-event").val(this.$selectedEvent.id);

                 $.ajax({
                      type: 'POST',
                      url: '<?php echo base_url();?>kinerja/ajax_detail_aktifitas',
                      data: 'id='+this.$selectedEvent.id,
                      success: function(msg) {
                        const obj = JSON.parse(msg);



                        l("#aktifitas").val(obj[0].nama_kegiatan),
                        l("#tanggal").val(obj[0].tgl),
                        l("#jam_mulai").val(obj[0].jam_mulai),
                        l("#jam_selesai").val(obj[0].jam_selesai),
                        l("#waktu_efektif").val(obj[0].waktu_efektif),
                        l("#volume").val(obj[0].volume),
                        l("#keterangan").val(obj[0].ket),
                        l("#event-category").val(this.$selectedEvent.classNames[0])

                      }
                  })


        },

        e.prototype.onSelect=function(e){
          this.$formEvent[0].reset(),
          this.$formEvent.removeClass("was-validated"),
          this.$selectedEvent=null,
          this.$newEventData=e,
          this.$btnDeleteEvent.hide(),
          this.$modalTitle.text("Input Aktifitas"),
          this.$modal.show(),this.$calendarObj.unselect();

          const tgl_pilih = this.$newEventData.date;
          const tgl       = tgl_pilih.getDate();
          const bulan     = tgl_pilih.getMonth() + 1;
          var tgl_format = '';
          var bulan_format = '';

          if(bulan < 10){
              var bulan_format = '0'+bulan;
          }else{
            var bulan_format = bulan;
          }

          if(tgl < 10){
              var tgl_format = '0'+tgl;
          }else{
            var tgl_format = tgl;
          }



          const formattedDate = `${tgl_format}-${bulan_format}-${tgl_pilih.getFullYear()}`;
          this.$dateActivity.val(formattedDate);

           $.ajax({
                      type: 'POST',
                      url: '<?php echo base_url();?>kinerja/ajax_get_absensi',
                      data: 'tanggal='+formattedDate,
                      success: function(msg) {
                        const obj_absen = JSON.parse(msg);
                        //this.$dateInfo.html(msg);
                        console.log(msg);
                        l("#title_date").html(obj_absen.day_date);
                        l("#absen_masuk").html(obj_absen.absen_masuk);
                        l("#absen_pulang").html(obj_absen.absen_pulang);
                        //$("#title_date").html(msg);
                      }
                  })

          
        },
        e.prototype.init=function(){
          var e=new Date(l.now());
          new FullCalendar.Draggable(document.getElementById("external-events"),
            {
              itemSelector:".external-event",
              eventData:function(e){
                return{
                  title:e.innerText,
                  className:l(e).data("class")
                }
              }
            });
            var t=<?php echo $json_aktifitas;?>,
              a=this;a.$calendarObj=new FullCalendar.Calendar(a.$calendar[0],
                {
                  slotDuration:"00:15:00",
                  slotMinTime:"08:00:00",
                  slotMaxTime:"19:00:00",
                  themeSystem:"bootstrap",
                  bootstrapFontAwesome:!1,
                  buttonText:{
                    today:"Today",
                    month:"Month",
                    prev:"Prev",
                    next:"Next"
                  },
                    initialView:"dayGridMonth",
                    handleWindowResize:!0,
                    height:l(window).height()-200,
                    headerToolbar:
                    {
                      left:"prev,next today",
                      center:"title",
                      right:""
                    },
                    initialEvents:t,editable:!0,droppable:!0,selectable:!0,
                    dateClick:function(e){a.onSelect(e)},
                    eventClick:function(e){a.onEventClick(e)
                    }
                  }
                ),
                a.$calendarObj.render(),
                a.$btnNewEvent.on("click",function(e){
                  a.onSelect({
                      date:new Date,allDay:!0
                    })
                  }),
                    a.$formEvent.on("submit",function(e){
                        e.preventDefault();
                        //  alert("test");
                        $.ajax({
                               type: 'POST',
                               url: $(this).attr('action'),
                               data: $(this).serialize(),
                               success: function(data) {
                                  window.location.reload();
                                //  alert("data berhasil disimpan");
                               }
                           })
                           return false;
                        }),

                        l(a.$btnDeleteEvent.on("click",function(e){

                                var id_event = $(this).val();

                                $.ajax({
                                      type: "POST",
                                      dataType: "html",
                                      url: "<?php echo base_url();?>kinerja/ajaxDeleteAktifitas",
                                      data: "id=" + id_event,
                                      success: function(msg) {
                                        console.log(msg);
                                      }
                                  });

                                a.$selectedEvent&&(a.$selectedEvent.remove(),
                                a.$selectedEvent=null,a.$modal.hide()
                                )}
                              )
                        )},
                        l.CalendarApp=new e,l.CalendarApp.Constructor=e
                      }(window.jQuery),

                      function(){"use strict";window.jQuery.CalendarApp.init()}();

                      </script>
    </body>
</html>
