<?php

/**
 * Created By Trimmytech
 * Fiverr Handle : @trimmytech
 * Date: 4/14/2018
 * Time: 9:26 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Paystack extends MX_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('finance/finance_model');
          $this->load->model('log/log_model');
    }

    private function getPaymentInfo($ref) {
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/' . $ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
                $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . PAYSTACK_SECRET_KEY]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        $result = json_decode($request, true);
        //
        return $result['data'];
    }

    public function verify_payment($ref) {
        $paystack = $this->db->get_where('paymentGateway', array('name =' => 'Paystack'))->row();
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/' . $ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
                $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $paystack->secret]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        if ($request) {
            $result = json_decode($request, true);
            // print_r($result);
            if ($result) {
                if ($result['data']) {
                    //something came in
                    if ($result['data']['status'] == 'success') {

                        //echo "Transaction was successful";
                        header("Location: " . base_url() . 'paystack/success/' . $ref);
                    } else {
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        header("Location: " . base_url() . 'paystack/fail/' . $ref);
                    }
                } else {

                    //echo $result['message'];
                    header("Location: " . base_url() . 'paystack/fail/' . $ref);
                }
            } else {
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                header("Location: " . base_url() . 'paystack/fail/' . $ref);
            }
        } else {
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            header("Location: " . base_url() . 'paystack/fail/' . $ref);
        }
    }

    public function paystack_standard($amount, $ref, $patient, $inserted_id, $user, $redirlink,$remarls="") {
        //

        $paystack = $this->db->get_where('paymentGateway', array('name =' => 'Paystack'))->row();
        $patientdetails = $this->db->get_where('patient', array('id =' => $patient))->row();
        $result = array();
        $amount = $amount * 100;
        if ($redirlink == '10') {
            $callback_url = base_url() . 'appointment';
        } elseif ($redirectlink == 'med_his') {
            $callback_url = base_url() . 'patient/medicalHistory?id=' . $patient;
        } elseif ($redirlink == 'my_today') {
            $callback_url = base_url() . 'appointment/todays';
        } elseif ($redirlink == 'upcoming') {
            $callback_url = base_url() . 'appointment/upcoming';
        } elseif ($redirlink == 'request') {
            $callback_url = base_url() . 'appointment/request';
        } elseif ($redirlink == '0') {
            $callback_url = base_url() . 'finance/invoice?id=' . $inserted_id;
        } else {
            if ($this->ion_auth->in_group(array('Patient'))) {
                $callback_url = base_url() . 'patient/myPaymentHistory';
            } else {
                $callback_url = base_url() . 'finance/patientPaymentHistory?patient=' . $patient;
            }
        }

        $postdata = array('first_name' => $patientdetails->name, 'email' => $patientdetails->email, 'amount' => $amount, "reference" => $ref, 'callback_url' => $callback_url);
        //

        $url = "https://api.paystack.co/transaction/initialize";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $headers = [
            'Authorization: Bearer ' . $paystack->secret,
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $request = curl_exec($ch);
        curl_close($ch);
        //
        //print_r($request);
        //   die();
        if ($request) {
            $result = json_decode($request, true);
            // return $result;
        }

        $redir = $result['data']['authorization_url'];

        header("Location: " . $redir);
        if ($result['status'] == 1) {
            $date = time();
            if ($redirlink == '10' || $redirlink == 'my_today' || $redirlink == 'upcoming' || $redirlink == 'med_his' || $redirlink == 'frontend') {
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'deposited_amount' => $amount / 100,
                    'payment_id' => $inserted_id,
                    'amount_received_id' => $inserted_id . '.' . 'gp',
                    'gateway' => 'Paystack',
                    'deposit_type' => 'Card',
                    'user' => $user,
                    'payment_from' => 'appointment'
                );
                $data_payment = array('amount_received' => $amount / 100, 'deposit_type' => 'Card', 'status' => 'paid', 'date' => time(), 'date_string' => date('d-m-y', time()));
                $this->finance_model->updatePayment($inserted_id, $data_payment);
                $appointment_id = $this->finance_model->getPaymentById($inserted_id)->appointment_id;
                $appointment_details = $this->appointment_model->getAppointmentById($appointment_id);
                if ($appointment_details->status == 'Requested') {
                    $data_appointment_status = array('status' => 'Confirmed', 'payment_status' => 'paid');
                } else {
                    $data_appointment_status = array('payment_status' => 'paid');
                }
                $this->appointment_model->updateAppointment($appointment_id, $data_appointment_status);
            } elseif ($redirlink == '0') {
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'deposited_amount' => $amount / 100,
                    'payment_id' => $inserted_id,
                    'amount_received_id' => $inserted_id . '.' . 'gp',
                    'gateway' => 'Paystack',
                    'deposit_type' => 'Card',
                    'user' => $user,
                    'payment_from' => 'payment'
                );
                $data_payment = array('amount_received' => $amount / 100, 'deposit_type' => 'Card');
                $this->finance_model->updatePayment($inserted_id, $data_payment);
            } else {
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'deposited_amount' => $amount / 100,
                    'payment_id' => $inserted_id,
                    'gateway' => 'Paystack',
                    'deposit_type' => 'Card',
                    'user' => $user,
                    'payment_from' => 'payment',
                    'remarks'=>$remarks
                );
            }
            $this->finance_model->insertDeposit($data1);
             $this->log_model->insertLog($this->ion_auth->get_user_id(), date('d-m-Y H:i:s', time()), 'Add new Payment(id='.$this->db->insert_id().' )', $this->db->insert_id());
        }
        //
        //   $data = array();
        //   $data['title'] = "Paystack Standard Demo";
        //
        //  $this->load->view('paystack_standard', $data);
    }

    public function paystack_inline() {
        $data = array();
        $data['title'] = "Paystack InLine Demo";
        //
        $this->load->view('paystack_inline', $data);
    }

    public function success($ref) {
        $data = array();
        $info = $this->getPaymentInfo($ref);
        //
        $data['title'] = "Paystack InLine Demo";
        $data['amount'] = $info['amount'] / 100;
        //
        $this->load->view('success', $data);
    }

    public function fail() {
        $this->load->view('fail');
    }

}

?>