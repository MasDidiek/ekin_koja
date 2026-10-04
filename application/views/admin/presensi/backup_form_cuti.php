 $this->load->library('form_validation');
        
        
        $countFile      =  count($_FILES['files']['name']);
        $data           = array(); 
        $errorUploadType = $statusMsg = ''; 
        $fileNmDb = ''; //nama file yang akan disimpan didatabase
        // If file upload form submitted 

        
        $nama_pegawai = $this->input->post('nama_pengganti');
        $row = $this->Pegawai_model->getPegawaiByNama($nama_pegawai);
        
        
        $this->form_validation->set_rules('id_pengganti', 'Nama Pengganti', 'required');
        $this->form_validation->set_rules('tlp', 'No telepon / HP', 'required');
        $this->form_validation->set_rules('alasan_cuti', 'Alasan Cuti', 'required');
        
        $this->form_validation->set_rules('tugas1', ' Delegasi Tugas harus diisi', 'required');
        $this->form_validation->set_rules('tugas2', ' Delegasi Tugas harus diisi', 'required');
        $this->form_validation->set_rules('tugas3', ' Delegasi Tugas harus diisi', 'required');
     



        if ($this->form_validation->run() == FALSE) {
         
                
            $pegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
            $id_jabatan = $pegawai[0]->id_jabatan;
    
    	  
            $this->db->select('id_pegawai, nama');
            $year = date('Y');
            $qry = $this->db->get_where('mst_pegawai', array('tahun_anggaran'=>  $year , 'id_jabatan'=> $id_jabatan, 'status_kerja'=> 1, 'id_pegawai !=' => $id_pegawai));
    
            $data['listPegawaiPengganti']   =  $qry->result();
            $data['cutiPegawai']            = $this->Cuti_model->getHistoryCutiPegawai($id_pegawai);
            $data['master_cuti']            = $this->Master_model->getlistCuti();
            
            $this->load->view('cuti/form_pengajuan_cuti', $data);
        } else {
           
    
            $jns_cuti         =  $this->session->userdata('jns_cuti');
            $this->session->set_userdata($this->input->post());
            
            if($jns_cuti  == 1){ 
                $id_cuti          =  $this->Cuti_model->insertDataCuti($fileNmDb);
                $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
                $date_from        =  $this->session->userdata('date_from');
                $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');
      
                if($jml_hari_cuti==1){
                    $tanggal = format_db($date_from);
                    $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                }else{
        
                    for ($i=0; $i < count($list_hari_cuti) ; $i++) {
                            $tanggal = $list_hari_cuti[$i];
                            $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                    }
                }
        
        
                $pesan =  createMessageInfo('Pengajuan cuti berhasil dikirim', 'success');
                $this->session->set_flashdata('message', $pesan);
    
                redirect('cuti/my_cuti');
        
            }else{
    
                //selain cuti tahunan
                $now = date('YmdHis');
                // If files are selected to upload 
                if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
                    $filesCount = count($_FILES['files']['name']); 
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 

                        $name_upload_file =  $_FILES['files']['name'][$i]; 


                        $extFile = getFileType($name_upload_file); //file extensi 

                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                        
                        
                        $fileName =  'cuti_'.$now;
                        // File upload configuration 
                        $uploadPath = 'uploads/cuti/'; 
                        $config['upload_path'] = $uploadPath; 
                        $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                        $config['file_name'] = $fileName;
                        $config['max_size']    = '5000'; 
                        $config['max_width'] = '5000'; 
                        $config['max_height'] = '5000'; 
                        
                        //Load and initialize upload library 
                        $this->load->library('upload', $config); 
                        $this->upload->initialize($config); 
                        
                        // Upload file to server 
                        if($this->upload->do_upload('file')){ 
                            // Uploaded file data 
                            $fileData = $this->upload->data(); 
                            $uploadData[$i]['file_name'] = $fileData['file_name']; 
                            $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                        }else{  
                            $errorUploadType .= $_FILES['file']['name'].' | ';  
                        } 

                        $fileNmDb .= $fileName.'.'.$extFile.',';
                    } 

                    $fileNmDb = rtrim($fileNmDb, " ,");


                    $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 

                    if(!empty($uploadData)){ 
                    // Insert files data into the database 
                        
                        $id_cuti          =  $this->Cuti_model->insertDataCuti($fileNmDb);
                        $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
                        $date_from        =  $this->session->userdata('date_from');
                        $date_to        =  $this->session->userdata('date_to');
                        $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');
                        
                        
     
                      
                
                        if($jml_hari_cuti==1){
                            $tanggal = format_db($date_from);
                            $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                        }else{
                        
                
                            $tgl_cuti = format_db($date_from);
                             $date_to = format_db($date_to);
                            
                    
                     
                            while ($tgl_cuti <=  $date_to) {
                              
                              $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tgl_cuti);
                              
                              $tgl_cuti = add_date($tgl_cuti, 1);
                              
                              $i++;
                            }

                            
                          
                        }
                
          
            
                    $pesan =  createMessageInfo('Pengajuan cuti berhasil dikirim', 'success');
                    $this->session->set_flashdata('message', $pesan);
            
                    redirect('cuti/detail_cuti/'.$id_cuti);
                          
                }else{ 
                    $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
                    $pesan =  createMessageInfo($statusMsg, 'danger');
                    $this->session->set_flashdata('message', $pesan);

                   
                    redirect('cuti/pengajuan_cuti_step2');
                } 

            }else{
                $statusMsg = 'Please select image files to upload.'; 
                $pesan =  createMessageInfo($statusMsg, 'danger');
                $this->session->set_flashdata('message', $pesan);

               
                redirect('cuti/pengajuan_cuti_step2');
            }
        }


        }