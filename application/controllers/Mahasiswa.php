<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Mahasiswa_model"); //load model mahasiswa
    }

    //method pertama yang akan di eksekusi
    public function index()
    {

        $data["title"] = "List Data Mahasiswa";
        //ambil fungsi getAll untuk menampilkan semua data mahasiswa
        $data["data_mahasiswa"] = $this->Mahasiswa_model->getAll();
        //load view header.php pada folder views/templates
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu');
        //load view index.php pada folder views/mahasiswa
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('templates/footer');
    }

    //method add digunakan untuk menampilkan form tambah data mahasiswa
    public function add()
    {
        $Mahasiswa = $this->Mahasiswa_model; //objek model
        $validation = $this->form_validation; //objek form validation
        $validation->set_rules($Mahasiswa->rules()); //menerapkan rules validasi pada mahasiswa_model
        //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method save pada mahasiswa_model
        if ($validation->run()) {
            $Mahasiswa->save();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Mahasiswa berhasil disimpan. 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
            redirect("mahasiswa");
        }
        $data["title"] = "Tambah Data Mahasiswa";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu');
        $this->load->view('mahasiswa/add', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('mahasiswa');

        $Mahasiswa = $this->Mahasiswa_model;
        $validation = $this->form_validation;
        $validation->set_rules($Mahasiswa->rules());

        if ($validation->run()) {
            $Mahasiswa->update();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Mahasiswa berhasil disimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
            redirect("mahasiswa");
        }
        $data["title"] = "Edit Data Mahasiswa";
        $data["data_mahasiswa"] = $Mahasiswa->getById($id);
        if (!$data["data_mahasiswa"]) show_404();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu');
        $this->load->view('mahasiswa/edit', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        $id = $this->input->get('id');
        if (!isset($id)) show_404();
        $this->Mahasiswa_model->delete($id);
        $msg['success'] = true;
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Mahasiswa berhasil dihapus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
        $this->output->set_output(json_encode($msg));
    }
}