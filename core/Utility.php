<?php

/**
 * 
 * This class is for project dependent functionalities   
 * @author Tejas Patel
 * @link tejas.patel@ithinkinfotech.com
 *
 */
class Utility {
	public static function clientType($selected = null){
		$options = array(
			"Individual" => "Individual",
			"Proprietor" => "Proprietor",
			"Partnership" => "Partnership",
			"LLP" => "LLP",
			"PVT LTD CO." => "PVT LTD CO.",
			"Public" => "Public",
			"Other" => "Other"  
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function salesTax($selected = null){
		$options = array(
			"Inclusive" => "Inclusive",
			"Exclusive" => "Exclusive",
			"N/A" => "N/A"
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function serviceTax($selected = null){
		$options = array(
			"Inclusive" => "Inclusive",
			"Exclusive" => "Exclusive"
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function YesNo($selected = null){
		$options = array(
			"Yes" => "Yes",
			"No" => "No"
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function openClose($selected = null){
		$options = array(
			"Open" => "Open",
			"Close" => "Close"
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function transactionTax($selected = null){
		$options = array(
			"Yes" => "Yes",
			"No" => "No"  
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function transactionType($selected = null){
		$options = array(
			"Demat" => "Demat",
			"Electronic" => "Electronic"
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function exchangeType($selected = null){
		$options = array(
			"Exchange" => "Exchange",
			"Non Exchange" => "Non Exchange"  
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	public static function counterPartyType($selected = null){
		$options = array(
			"Client" => "Client",
			"Counter Party" => "Counter Party"  
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	public static function originalReceiptReceived($selected = null){
		$options = array(
			"No" => "No",
			"Yes" => "Yes"  
		);
		return Core::ArrayToHTMLOptions($options, $selected);
	}
	
	/*
	 * Tabel names shows in front end 
	 */
	public static $log_id_field = array(
		"user" 	=> "User Master",
		"tbl_wsp" 	=> "WSP Master",
		"tbl_wsp_locations"=> "WSP Location",
		"tbl_wsp_rent_details"=>"WSP Rent Details",
		"tbl_wsp_rent_details_history"=>"WSP Rent Details History",
		"tbl_banks" => "Bank Master",
		"tbl_bank_interest_details" => "Bank Interest Details",
		"tbl_bank_interest_details_history" => "Bank Interest Details History",
		"tbl_buy_sell_entry" => "Buy Sell Entry",
		"tbl_clients" => "Clients",
		"tbl_client_authorized_signatory" => "Client Authorized Signatory",
		"tbl_client_bank_details" => "Client Bank Details",
		"tbl_client_director_details" => "Client Director Detail",
		"tbl_client_ref_details" => "Client Ref Detail",
		"tbl_commodity_inward_entry" => "Commodity Inward Entry",
		"tbl_commodity_inward_entry_lots" => "Commodity Inward Entry Lots",
		"tbl_commodity_inward_entry_lot_multiple_deals" => "Commodity Inward Entry Multiple Deals",
		"tbl_commodity_inward_entry_lot_weight_bridge" => "Commodity Inward Entry Weight Bridge",
		"tbl_comtrack_inventory" => "Comtrack Inventory",
		"tbl_cfagents" => "C & F Agents Master",
		"tbl_cfagent_locations" => "C & F Location",
		"tbl_cfagent_charges" => "C & F Charges", 
		"tbl_cfagent_charges_history" => "C & F Charges History",
		"tbl_client_hurdle_rate" => "Client Hurdle Rate",
		"tbl_exchange_brokers" => "Exchange Broker Basic Details",
		"tbl_exchange_broker_bank_details" => "Exchange Broker Bank Details",
		"tbl_exchange_broker_brokerage_details" => "Exchange Broker Brokerage Details",
		"tbl_client_exchange_broker_details" => "Cllient Exchange Broker Account Details",
		"tbl_location" => "Location Master",
		"tbl_exchange" => "Exchange Master",
		"tbl_counter_party" => "Counter Party Master",
		"tbl_counter_party_bank_details" => "Counter Party Details",
		"tbl_commodities" => "Commodities Master",
		"tbl_commodity_grade" => "Commodity Grade Master",
		"tbl_commodity_location" => "Commodity Location Master",
		"tbl_commodity_discount" => "Commodity Discount Details",
		"tbl_commodity_discount_history" => "Commodity Discount History",
		"tbl_future_trades"=>"Future Trade",
		"tbl_physical_broker" => "Physical Broker Master",
		"tbl_physical_broker_bank_details" => "Physical Broker Bank Details",
		"tbl_physical_broker_brokerage_details" => "Physical Broker - Brokerage Details",
		"tbl_physical_broker_brokerage_details_history" => "Physical Broker - Brokerage History",
		"tbl_buy_sell_entry" => "Buy Sell Entry",
		"tbl_comtrack_inventory" => "Comtrack Inventory",
		"tbl_strategy" => "Strategy Master",
		"tbl_wh_receipt" => "WH Receipt",
		"tbl_wh_receipt_lots" => "WH Receipt Lots",
		"tbl_lab_report" => "Lab Reports",
		"tbl_lab_report_lots" => "Lab Report Lots",
		"tbl_pledges" => "Pledges",
		"tbl_payee_master"=>"Payee Master",
		"tbl_commodity_inward_entry" => "Commodity Inward Entry",
		"tbl_commodity_inward_entry_lots" => "Commodity Inward Entry Lots",
		"tbl_commodity_inward_entry_lot_multiple_deals" => "Commodity Inward Multiple Deal",
		"tbl_commodity_inward_entry_lot_weight_bridge" => "Commodity Inward Weight Bridge",
		"tbl_selldeallot" => "Sell Deal Lot",
		"tbl_commodity_outward" => "Commodity Outward",
		"tbl_cdfentry" => "CDF Entry",
		"tbl_cash_flow"=>"Cash Flow",
		"tbl_commodity_vat" => "Commodity VAT Details",
		"tbl_commodity_vat_history" => "Commodity VAT History",
		"tbl_initial_payment_master" => "Initial Payment Master",
		"tbl_invoice_entry" => "Invoice Details",
		"tbl_debitcreditnote" => "Debit Credit Note",
		"tbl_unpledge" => "Unpledge"
	);
	
	/*
	 * This function checks the foreign key values to its original value
	 */
	public static $table_id_name = array(
		"permissions"=>"perm_desc",
		"roles"=>"role_name",
		"tbl_banks"=>"name",
		"tbl_cfagents"=>"cfagent_manual_id",
		"tbl_client_authorized_signatory"=>"authorized_signatory",
		"tbl_client_bank_details"=>"bank_name",
		"tbl_client_director_details"=>"director_name",
		"tbl_client_ref_details"=>"ref_name",
		"tbl_clients"=>"client_name",
		"tbl_commodities"=>"commodity_name",
		"tbl_commodity_grade"=>"grade",
		"tbl_commodity_location"=>"location_name",
		"tbl_commodity_inward_entry"=>"hologram_no",
		"tbl_commodity_inward_entry_lot_multiple_deals"=>"deal_no",
		"tbl_commodity_inward_entry_lot_weight_bridge"=>"weight_bridge_name",
		"tbl_commodity_inward_entry_lots"=>"godown_no",
		"tbl_counter_party"=>"counter_party_manual_id",
		"tbl_counter_party_bank_details"=>"bank_name",
		"tbl_exchange"=>"exchange_name",
		"tbl_exchange_broker_bank_details"=>"bank_name",
		"tbl_exchange_brokers"=>"broker_name",
		"tbl_lab_report"=>"lab_report_no",
		"tbl_location"=>"location_name",
		"tbl_physical_broker"=>"physical_broker_manual_id",
		"tbl_states"=>"state_name",
		"tbl_strategy"=>"strategy_name",
		"tbl_wsp"=>"wsp_name",
		"user"=>"user_name",
		"tbl_commodity_outward" => "manual_commodityoutward_id",
		"tbl_cdfentry" => "cdf_no",
		"tbl_comtrack_inventory" => "cmse_lot_id",
		"tbl_selldeallot" => "manual_selldeallot_id"
	);

	public static $table_maker_checker = array(
		"user"=>array("email_id","contact_no")
	);

}
?>