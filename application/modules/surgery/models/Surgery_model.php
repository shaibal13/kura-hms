<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Surgery_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertSurgery($data) {

        $this->db->insert('surgery', $data);
    }

    function updateSurgery($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('surgery', $data);
    }

    function getSurgeryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('surgery');
        return $query->row();
    }

    function getSurgery() {
        $query = $this->db->get('surgery');
        return $query->result();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('surgery');
    }

    function insertSurgeryCheckin($data) {

        $this->db->insert('surgery_checkin', $data);
    }

    function getSurgeryCheckinById($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('surgery_checkin');
        return $query->row();
    }

    function updateSurgeryCheckin($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('surgery_checkin', $data);
    }

    function insertPreSurgeryMedicalAnalysis($data) {

        $this->db->insert('pre_surgery_medical_analysis', $data);
    }

    function getPreSurgeryMedicalAnalysisByStatus($status) {
        return $this->db->where('status', $status)
                        ->get('pre_surgery_medical_analysis')->result();
    }

    function updatePreSurgeryMedicalAnalysis($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('pre_surgery_medical_analysis', $data);
    }

    function getPreSurgeryMedicalAnalysisBySurgeryId($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('pre_surgery_medical_analysis');
        return $query->row();
    }

    function getPreSurgeryMedicalAnalysisById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('pre_surgery_medical_analysis');
        return $query->row();
    }

    function getPreSurgeryMedicalAnalysisBySurgeryIdAll($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('pre_surgery_medical_analysis');
        return $query->result();
    }

    function deletePreMedicalSurgery($id) {
        $this->db->where('id', $id);
        $this->db->delete('pre_surgery_medical_analysis');
    }

    function insertOnSurgeryMedicalAnalysis($data) {

        $this->db->insert('on_surgery_medical_analysis', $data);
    }

    function updateOnSurgeryMedicalAnalysis($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('on_surgery_medical_analysis', $data);
    }

    function getOnSurgeryMedicalAnalysisBySurgeryId($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('on_surgery_medical_analysis');
        return $query->row();
    }

    function getOnSurgeryMedicalAnalysisByStatus($status) {
        return $this->db->where('status', $status)
                        ->get('on_surgery_medical_analysis')->result();
    }

    function getOnSurgeryMedicalAnalysisById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('on_surgery_medical_analysis');
        return $query->row();
    }

    function getOnSurgeryMedicalAnalysisBySurgeryIdAll($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('on_surgery_medical_analysis');
        return $query->result();
    }

    function deleteOnMedicalSurgery($id) {
        $this->db->where('id', $id);
        $this->db->delete('on_surgery_medical_analysis');
    }

    function insertPostSurgeryMedicalAnalysis($data) {

        $this->db->insert('post_surgery_medical_analysis', $data);
    }

    function updatePostSurgeryMedicalAnalysis($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('post_surgery_medical_analysis', $data);
    }

    function getPostSurgeryMedicalAnalysisByStatus($status) {
        return $this->db->where('status', $status)
                        ->get('post_surgery_medical_analysis')->result();
    }

    function getPostSurgeryMedicalAnalysisBySurgeryId($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('post_surgery_medical_analysis');
        return $query->row();
    }

    function getPostSurgeryMedicalAnalysisById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('post_surgery_medical_analysis');
        return $query->row();
    }

    function getPostSurgeryMedicalAnalysisBySurgeryIdAll($surgery) {
        $this->db->where('surgery_id', $surgery);
        $query = $this->db->get('post_surgery_medical_analysis');
        return $query->result();
    }

    function deletePostMedicalSurgery($id) {
        $this->db->where('id', $id);
        $this->db->delete('post_surgery_medical_analysis');
    }

    function getMedicineForPreSurgery($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('pre_surgery_medicine')->result();
    }

    function insertPreSurgeryMedicine($data) {

        //  $data2 = array_merge($data, $data1);
        $this->db->insert('pre_surgery_medicine', $data);
    }

    function getPreSurgeryMedicineById($id) {
        return $this->db->where('id', $id)
                        ->get('pre_surgery_medicine')->row();
    }

    function updatePreSurgeryMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('pre_surgery_medicine', $data);
    }

    function deletePreSurgeryMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('pre_surgery_medicine');
    }

    function getMedicineForOnSurgery($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('on_surgery_medicine')->result();
    }

    function insertOnSurgeryMedicine($data) {

        //  $data2 = array_merge($data, $data1);
        $this->db->insert('on_surgery_medicine', $data);
    }

    function getOnSurgeryMedicineById($id) {
        return $this->db->where('id', $id)
                        ->get('on_surgery_medicine')->row();
    }

    function updateOnSurgeryMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('on_surgery_medicine', $data);
    }

    function deleteOnSurgeryMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('on_surgery_medicine');
    }

    function getMedicineForPostSurgery($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('post_surgery_medicine')->result();
    }

    function insertPostSurgeryMedicine($data) {

        //  $data2 = array_merge($data, $data1);
        $this->db->insert('post_surgery_medicine', $data);
    }

    function getPostSurgeryMedicineById($id) {
        return $this->db->where('id', $id)
                        ->get('post_surgery_medicine')->row();
    }

    function updatePostSurgeryMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('post_surgery_medicine', $data);
    }

    function deletePostSurgeryMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('post_surgery_medicine');
    }

    function getPreServiceBySurgeryId($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('pre_service')->result();
    }

    function deletePreServices($id) {
        $this->db->where('id', $id);
        $this->db->delete('pre_service');
    }

    function getPreServicesByDate($date) {
        return $this->db->where('date', $date)
                        ->get('pre_service')->row();
    }

    function updatePreServices($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('pre_service', $data);
    }

    function insertPreServices($data) {

        //$data2 = array_merge($data, $data1);
        $this->db->insert('pre_service', $data);
    }

    function getPreServiceById($id) {
        return $this->db->where('id', $id)
                        ->get('pre_service')->row();
    }

    function getPreServicedByIdByDate($id) {
        return $this->db->where('surgery_id', $id)
                        ->where('date', date('d-m-Y'))
                        ->get('pre_service')->row();
    }

    function getOnServiceBySurgeryId($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('on_service')->result();
    }

    function deleteOnServices($id) {
        $this->db->where('id', $id);
        $this->db->delete('on_service');
    }

    function getOnServicesByDate($date) {
        return $this->db->where('date', $date)
                        ->get('on_service')->row();
    }

    function updateOnServices($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('on_service', $data);
    }

    function insertOnServices($data) {

        //$data2 = array_merge($data, $data1);
        $this->db->insert('on_service', $data);
    }

    function getOnServiceById($id) {
        return $this->db->where('id', $id)
                        ->get('on_service')->row();
    }

    function getOnServicedByIdByDate($id) {
        return $this->db->where('surgery_id', $id)
                        ->where('date', date('d-m-Y'))
                        ->get('on_service')->row();
    }

    function getPostServiceBySurgeryId($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('post_service')->result();
    }

    function deletePostServices($id) {
        $this->db->where('id', $id);
        $this->db->delete('post_service');
    }

    function getPostServicesByDate($date) {
        return $this->db->where('date', $date)
                        ->get('post_service')->row();
    }

    function updatePostServices($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('post_service', $data);
    }

    function insertPostServices($data) {

        //$data2 = array_merge($data, $data1);
        $this->db->insert('post_service', $data);
    }

    function getPostServiceById($id) {
        return $this->db->where('id', $id)
                        ->get('post_service')->row();
    }

    function getPostServicedByIdByDate($id) {
        return $this->db->where('surgery_id', $id)
                        ->where('date', date('d-m-Y'))
                        ->get('post_service')->row();
    }

    function updateCheckout($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('surgery_checkout', $data);
    }

    function insertCheckout($data) {

        //  $data2 = array_merge($data, $data1);
        $this->db->insert('surgery_checkout', $data);
    }

    function getCheckoutdById($id) {
        return $this->db->where('id', $id)
                        ->get('surgery_checkout')->row();
    }

    function getCheckoutBySurgeryId($id) {
        return $this->db->where('surgery_id', $id)
                        ->get('surgery_checkout')->row();
    }

}
