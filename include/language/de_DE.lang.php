<?php

/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2010 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
	
$app_strings = array (
  'LBL_LIST_TEAM' => 'Team',
  'LBL_TEAM' => 'Team',
  'LBL_TEAM_ID' => 'Team ID',
  'ERR_CREATING_FIELDS' => 'Fehler beim Ausfüllen von zusätzlichen Detailfeldern:',
  'ERR_CREATING_TABLE' => 'Fehler beim Anlegen der Tabelle:',
  'ERR_EXPORT_DISABLED' => 'Exporte deaktiviert',
  'ERR_EXPORT_TYPE' => 'Fehler beim Exportieren',
  'ERR_INVALID_AMOUNT' => 'Bitte gültigen Betrag eingeben.',
  'ERR_INVALID_DATE_FORMAT' => 'Das Datumsformat muss sein:',
  'LBL_SQS_INDICATOR' => '',
);

$app_list_strings = array (
  'sales_stage_dom' => 
  array (
    'Id. Decision Makers' => 'Entscheidungsträger',
    'Prospecting' => 'Prospecting',
    'Qualification' => 'Qualifizierung',
    'Needs Analysis' => 'Bedarfsanalyse',
    'Value Proposition' => 'Wertanalyse',
    'Perception Analysis' => 'Vorstellungsalignment',
    'Proposal/Price Quote' => 'Angebot',
    'Negotiation/Review' => 'Verhandlung',
    'Closed Won' => 'gewonnen',
    'Closed Lost' => 'verloren',
  ),
  'sales_probability_dom' => 
  array (
    'Id. Decision Makers' => '40',
    'Prospecting' => '10',
    'Qualification' => '20',
    'Needs Analysis' => '25',
    'Value Proposition' => '30',
    'Perception Analysis' => '50',
    'Proposal/Price Quote' => '65',
    'Negotiation/Review' => '80',
    'Closed Won' => '100',
    'Closed Lost' => 'Verloren',
  ),
  'salutation_dom' => 
  array (
    'Mr.' => 'Herr',
    'Ms.' => 'Frau',
    'Mrs.' => 'Frau',
    'Dr.' => 'Dr.',
    'Prof.' => 'Prof.',
    '' => '',
  ),
  'sales_stage_default_key' => 'Prospecting',
  'case_priority_default_key' => 'P2',
  'product_status_default_key' => 'Ship',
  'pricing_formula_default_key' => 'Fixed',
  'default_order_stage_key' => 'Pending',
  'moduleList' => 
  array (
    'Home' => 'Home',
    'Teams' => 'Teams',
    'FAQ' => 'FAQ',
    'Bugs' => 'Fehlerverfolgung',
    'Cases' => 'Fälle',
    'Notes' => 'Notizen',
    'Newsletters' => 'Newsletter',
    'Users' => 'Benutzer',
    'KBDocuments' => 'Wissensbasis',
  ),
  'moduleListSingular' => 
  array (
    'Home' => 'Home',
    'Teams' => 'Team',
    'Bugs' => 'Fehler',
    'Cases' => 'Fälle',
    'Notes' => 'Notizen',
    'Users' => 'Benutzer',
  ),
  'account_type_dom' => 
  array (
    'Analyst' => 'Analyst',
    'Integrator' => 'Integrator',
    'Investor' => 'Investor',
    'Partner' => 'Partner',
    '' => ' ',
    'Competitor' => 'Mitbewerber',
    'Customer' => 'Kunde',
    'Press' => 'Presse',
    'Prospect' => 'Potentieller Kunde',
    'Reseller' => 'Wiederverkäufer',
    'Other' => 'Andere',
  ),
  'lead_source_dom' => 
  array (
    'Partner' => 'Partner',
    'Public Relations' => 'Public Relations',
    'Email' => 'Email',
    '' => ' ',
    'Cold Call' => 'Kalt Akquise',
    'Existing Customer' => 'Bestehender Kunde',
    'Self Generated' => 'Selbst generierter Kunde',
    'Employee' => 'Mitarbeiter',
    'Direct Mail' => 'Aussendung',
    'Conference' => 'Konferenz',
    'Trade Show' => 'Messe',
    'Web Site' => 'Web Seite',
    'Word of mouth' => 'Mund zu Mund Propaganda',
    'Other' => 'Andere',
  ),
  'opportunity_relationship_type_dom' => 
  array (
    'Executive Sponsor' => 'Executive Sponsor',
    '' => ' ',
    'Primary Decision Maker' => 'Hauptentscheidungsträger',
    'Business Decision Maker' => 'Business Entscheidungsträger',
    'Business Evaluator' => 'Business Vorentscheider',
    'Technical Decision Maker' => 'Technischer Entscheidungsträger',
    'Technical Evaluator' => 'Technik Vorentscheider',
    'Influencer' => 'Einflussreiche Person',
    'Other' => 'Andere:',
  ),
  'case_relationship_type_dom' => 
  array (
    '' => '',
    'Primary Contact' => 'Hauptkontakt',
    'Alternate Contact' => 'Alternativkontakt',
  ),
  'payment_terms' => 
  array (
    '' => '',
    'Net 15' => '15 Tage netto',
    'Net 30' => '30 Tage netto',
  ),
  'activity_dom' => 
  array (
    'Email' => 'Email',
    'Call' => 'Anruf:',
    'Meeting' => 'Meeting:',
    'Task' => 'Aufgabe',
    'Note' => 'Notiz',
  ),
  'lead_status_dom' => 
  array (
    '' => '',
    'New' => 'Neu',
    'Assigned' => 'Zugewiesen',
    'In Process' => 'In Arbeit',
    'Converted' => 'Umgewandelt',
    'Recycled' => 'Wiederaufgenommen',
    'Dead' => 'Ausgeschieden',
  ),
  'messenger_type_dom' => 
  array (
    '' => '',
    'MSN' => 'MSN',
    'Yahoo!' => 'Yahoo!',
    'AOL' => 'AOL',
  ),
  'project_task_utilization_options' => 
  array (
    25 => '25',
    50 => '50',
    75 => '75',
    100 => '100',
    0 => 'keine',
  ),
  'order_stage_dom' => 
  array (
    'Pending' => 'Pending',
    'Confirmed' => 'Bestätigt',
    'On Hold' => 'Zurückgestellt',
    'Shipped' => 'Geliefert',
    'Cancelled' => 'Storniert',
  ),
  'quote_relationship_type_dom' => 
  array (
    'Executive Sponsor' => 'Executive Sponsor',
    '' => ' ',
    'Primary Decision Maker' => 'Hauptentscheidungsträger',
    'Business Decision Maker' => 'Business Entscheidungsträger',
    'Business Evaluator' => 'Business Vorentscheider',
    'Technical Decision Maker' => 'Technischer Entscheidungsträger',
    'Technical Evaluator' => 'Technik Vorentscheider',
    'Influencer' => 'Einflussreiche Person',
    'Other' => 'Andere',
  ),
  'bug_status_dom' => 
  array (
    'Pending' => 'Pending',
    'New' => 'Neu',
    'Assigned' => 'Zugewiesen',
    'Closed' => 'Abgeschlossen',
    'Rejected' => 'Abgelehnt',
  ),
  'source_dom' => 
  array (
    'Forum' => 'Forum',
    'Web' => 'Web',
    'InboundEmail' => 'Email',
    '' => ' ',
    'Internal' => 'Intern',
  ),
  'product_category_dom' => 
  array (
    'Emails' => 'Emails',
    'Feeds' => 'Feeds',
    'Home' => 'Home',
    'Outlook Plugin' => 'Outlook Plugin',
    'Releases' => 'Releases',
    'RSS' => 'RSS',
    'Studio' => 'Studio',
    'Upgrade' => 'Upgrade',
    '' => ' ',
    'Accounts' => 'Firmen',
    'Activities' => 'Aktivitäten',
    'Bug Tracker' => 'Fehlerverfolgung',
    'Calendar' => 'Kalender',
    'Calls' => 'Anrufe',
    'Campaigns' => 'Kampagnen',
    'Cases' => 'Fälle',
    'Contacts' => 'Kontakte',
    'Currencies' => 'Währungen',
    'Dashboard' => 'Übersicht',
    'Documents' => 'Dokumente',
    'Forecasts' => 'Prognosen',
    'Help' => 'Hilfe',
    'Leads' => 'Interessenten',
    'Meetings' => 'Termine',
    'Notes' => 'Notizen',
    'Opportunities' => 'Verkaufschancen',
    'Product Catalog' => 'Produktkatalog',
    'Products' => 'Produkte',
    'Projects' => 'Projekte',
    'Quotes' => 'Angebote',
    'Users' => 'Benutzer',
  ),
  'campaign_type_dom' => 
  array (
    'Mail' => 'Mail',
    'Email' => 'Email',
    'Web' => 'Web',
    '' => ' ',
    'Telesales' => 'Telefonverkauf',
    'Print' => 'Drucken',
    'Radio' => 'Radio Button',
    'Television' => 'Fernsehen',
  ),
  'notifymail_sendtype' => 
  array (
    'SMTP' => 'SMTP',
  ),
  'dom_timezones' => 
  array (
    -11 => '(GMT - 11) Midway Island, Samoa',
    -10 => '(GMT - 10) Hawaii',
    -8 => '(GMT - 8) San Francisco',
    -7 => '(GMT - 7) Phoenix',
    -6 => '(GMT - 6) Saskatchewan',
    -5 => '(GMT - 5) New York',
    -4 => '(GMT - 4) Santiago',
    -3 => '(GMT - 3) Buenos Aires',
    -2 => '(GMT - 2) Mid-Atlantic',
    -1 => '(GMT - 1) Azores',
    1 => '(GMT + 1) Madrid',
    2 => '(GMT + 2) Athens',
    4 => '(GMT + 4) Kabul',
    5 => '(GMT + 5) Ekaterinburg',
    6 => '(GMT + 6) Astana',
    7 => '(GMT + 7) Bangkok',
    8 => '(GMT + 8) Perth',
    9 => '(GMT + 9) Seol',
    10 => '(GMT + 10) Brisbane',
    11 => '(GMT + 11) Solomone Is.',
    12 => '(GMT + 12) Auckland',
    -12 => '(GMT - 12) International Date Line West
',
    -9 => ' -9
(GMT - 9) Alaska',
    0 => 'GMT',
    3 => '(GMT + 2) Athens',
  ),
  'dom_cal_month_long' => 
  array (
    4 => 'April',
    8 => 'August',
    9 => 'September',
    11 => 'November',
    0 => ' 0',
    1 => 'Januar',
    2 => 'Februar',
    3 => 'März',
    5 => 'Mai',
    6 => 'Juni',
    7 => 'Juli',
    10 => 'Oktober',
    12 => 'Dezember',
  ),
  'dom_email_server_type' => 
  array (
    'imap' => 'IMAP',
    'pop3' => 'POP3',
    '' => ' ',
  ),
  'dom_email_editor_option' => 
  array (
    'plain' => 'Plain Text Email',
    '' => ' ',
    'html' => 'HTML E-Mail',
  ),
  'forecast_type_dom' => 
  array (
    'Rollup' => 'Rollup',
    'Direct' => 'Direkt',
  ),
  'document_category_dom' => 
  array (
    'Marketing' => 'Marketing',
    '' => ' ',
    'Knowledege Base' => 'Wissensbasis',
    'Sales' => 'Verkauf',
  ),
  'document_subcategory_dom' => 
  array (
    'FAQ' => 'FAQ',
    '' => ' ',
    'Marketing Collateral' => 'Werbematerial',
    'Product Brochures' => 'Produktbroschüren',
  ),
  'document_status_dom' => 
  array (
    'FAQ' => 'FAQ',
    'Pending' => 'Pending',
    'Active' => 'Aktiv',
    'Draft' => 'Entwurf',
    'Expired' => 'Abgelaufen',
    'Under Review' => 'Wird überprüft',
  ),
  'document_template_type_dom' => 
  array (
    'eula' => 'EULA',
    'nda' => 'NDA',
    '' => ' ',
    'mailmerge' => 'Serienbrief',
    'license' => 'Lizenz Vereinbarung',
  ),
  'query_calc_oper_dom' => 
  array (
    '+' => '(+) Plus',
    '-' => '(-) Minus',
    '*' => '(*) Multiplikation',
    '/' => '(/) Division',
  ),
  'wflow_alert_type_dom' => 
  array (
    'Email' => 'Email',
    'Invite' => 'Einladung',
  ),
  'wflow_address_type_invite_dom' => 
  array (
    'invite_only' => '(Invite Only)',
    'to' => 'An:',
    'cc' => 'Cc:',
    'bcc' => 'Bcc:',
  ),
  'wflow_rel_type_dom' => 
  array (
    'filter' => 'Filter related',
    'all' => 'Alle',
  ),
  'dom_timezones_extra' => 
  array (
    -11 => '(GMT-11) Midway Island, Samoa',
    -10 => '(GMT-10) Hawaii',
    -9 => '(GMT-9) Alaska',
    -8 => '(GMT-8) (PST)',
    -7 => '(GMT-7) (MST)',
    -6 => '(GMT-6) (CST)',
    -4 => '(GMT-4) Santiago',
    -3 => '(GMT-3) Buenos Aires',
    -2 => '(GMT-2) Mid-Atlantic',
    -1 => '(GMT-1) Azores',
    0 => '(GMT)',
    1 => '(GMT+1) Madrid',
    2 => '(GMT+2) Athens',
    3 => '(GMT+3) Moscow',
    4 => '(GMT+4) Kabul',
    5 => '(GMT+5) Ekaterinburg',
    6 => '(GMT+6) Astana',
    7 => '(GMT+7) Bangkok',
    8 => '(GMT+8) Perth',
    9 => '(GMT+9) Seol',
    10 => '(GMT+10) Brisbane',
    11 => '(GMT+11) Solomone Is.',
    12 => '(GMT+12) Auckland',
    -12 => '12
(GMT-12) International Date Line West',
    -5 => '(GMT-5) (EST)
',
  ),
  'duration_intervals' => 
  array (
    0 => '00',
    15 => '15',
    30 => '30',
    45 => '45',
  ),
  'prospect_list_type_dom' => 
  array (
    'test' => 'Test',
    'default' => 'Standard',
    'seed' => 'Muster',
    'exempt_domain' => 'Unterdrückungs Liste - nach Domäne',
    'exempt_address' => 'Unterdrückungs Liste - nach E-Mail Adresse',
    'exempt' => 'Unterdrückungs Liste - nach ID',
  ),
  'campainglog_activity_type_dom' => 
  array (
    'removed' => 'Opted Out',
    '' => ' ',
    'targeted' => 'Nachricht gesendet/versucht',
    'send error' => 'Nicht zustellbar, andere',
    'invalid email' => 'Nicht zustellbar, ungültige E-Mail',
    'link' => 'Klickbarer Link',
    'viewed' => 'Gelesene Mitteilung',
    'lead' => 'Erstellte Intessenten',
    'contact' => 'Neue Kontakte',
  ),
  'language_pack_name' => 'Deutsch',
  'lead_source_default_key' => 'Selbst generierter Kunde',
  'opportunity_relationship_type_default_key' => 'Hauptentscheidungsträger',
  'case_relationship_type_default_key' => 'Hauptkontakt',
  'reminder_max_time' => '3600',
  'task_priority_default' => 'Mittel',
  'task_status_default' => 'Nicht begonnen',
  'meeting_status_default' => 'Geplant',
  'call_status_default' => 'Geplant',
  'call_direction_default' => 'Ausgehend',
  'case_status_default_key' => 'Neu',
  'record_type_default_key' => 'Firmen',
  'product_status_quote_key' => 'Angebote',
  'default_quote_stage_key' => 'Entwurf',
  'quote_relationship_type_default_key' => 'Hauptentscheidungsträger',
  'bug_priority_default_key' => 'Mittel',
  'bug_resolution_default_key' => ' ',
  'bug_status_default_key' => 'Neu',
  'bug_type_default_key' => 'Fehler:',
  'source_default_key' => 'source_default_key ',
  'product_category_default_key' => 'source_default_key ',
  'checkbox_dom' => 
  array (
    '' => ' ',
    1 => 'Ja',
    2 => 'Nein',
  ),
  'industry_dom' => 
  array (
    '' => ' ',
    'Apparel' => 'Bekleidungsindustrie',
    'Banking' => 'Bankwesen',
    'Biotechnology' => 'Biotechnologie',
    'Chemicals' => 'Chemieindustrie',
    'Communications' => 'Kommunikation',
    'Construction' => 'Baugewerbe',
    'Consulting' => 'Beratung',
    'Education' => 'Bildungwesen',
    'Electronics' => 'Elektronik',
    'Energy' => 'Energieerzeuger',
    'Engineering' => 'Entwicklung',
    'Entertainment' => 'Unterhaltungsindustrie',
    'Environmental' => 'Umwelt',
    'Finance' => 'Finanzsektor',
    'Government' => 'Öffentliche Einrichtung',
    'Healthcare' => 'Gesundheitswesen',
    'Hospitality' => 'Gastgewerbe',
    'Insurance' => 'Versicherung',
    'Machinery' => 'Maschinenbau',
    'Manufacturing' => 'Produktion',
    'Media' => 'Medien',
    'Not For Profit' => 'Gemeinnützige Organisation',
    'Recreation' => 'Freizeitindustrie',
    'Retail' => 'Einzelhandel',
    'Shipping' => 'Versandhandel',
    'Technology' => 'Technologie',
    'Telecommunications' => 'Telekommunikation',
    'Transportation' => 'Transportwesen',
    'Utilities' => 'Energieversorger',
    'Other' => 'Andere',
  ),
  'opportunity_type_dom' => 
  array (
    '' => ' ',
    'Existing Business' => 'Bestandskunde',
    'New Business' => 'Neukunde',
  ),
  'reminder_time_options' => 
  array (
    60 => '1 Minute davor',
    300 => '5 Minuten davor',
    600 => '10 Minuten davor',
    900 => '15 Minuten davor',
    1800 => '30 Minuten davor',
    3600 => '1 Stunde davor',
  ),
  'task_priority_dom' => 
  array (
    'High' => 'Hoch',
    'Medium' => 'Mittel',
    'Low' => 'Niedrig',
  ),
  'task_status_dom' => 
  array (
    'Not Started' => 'Nicht begonnen',
    'In Progress' => 'In Bearbeitung',
    'Completed' => 'Abgeschlossen',
    'Pending Input' => 'Rückmeldung ausstehend',
    'Deferred' => 'Zurückgestellt',
  ),
  'meeting_status_dom' => 
  array (
    'Planned' => 'Geplant',
    'Held' => 'Durchgeführt',
    'Not Held' => 'Nicht durchgeführt',
  ),
  'call_status_dom' => 
  array (
    'Planned' => 'Geplant',
    'Held' => 'Durchgeführt',
    'Not Held' => 'Nicht durchgeführt',
  ),
  'call_direction_dom' => 
  array (
    'Inbound' => 'Eingehend',
    'Outbound' => 'Ausgehend',
  ),
  'lead_status_noblank_dom' => 
  array (
    'New' => 'Neu',
    'Assigned' => 'Zugewiesen',
    'In Process' => 'In Arbeit',
    'Converted' => 'Umgewandelt',
    'Recycled' => 'Wiederaufgenommen',
    'Dead' => 'Ausgeschieden',
  ),
  'case_status_dom' => 
  array (
    'New' => 'Neu',
    'Assigned' => 'Zugewiesen',
    'Closed' => 'Abgeschlossen',
    'Pending Input' => 'Rückmeldung ausstehend',
    'Rejected' => 'Abgelehnt',
    'Duplicate' => 'Duplikat',
  ),
  'case_priority_dom' => 
  array (
    'P1' => 'Hoch',
    'P2' => 'Mittel',
    'P3' => 'Niedrig',
  ),
  'user_status_dom' => 
  array (
    'Active' => 'Aktiv',
    'Inactive' => 'Inaktiv',
  ),
  'employee_status_dom' => 
  array (
    'Active' => 'Aktiv',
    'Terminated' => 'Beendet',
    'Leave of Absence' => 'Abwesend',
  ),
  'project_task_priority_options' => 
  array (
    'High' => 'Hoch',
    'Medium' => 'Mittel',
    'Low' => 'Niedrig',
  ),
  'project_task_status_options' => 
  array (
    'Not Started' => 'Nicht begonnen',
    'In Progress' => 'In Bearbeitung',
    'Completed' => 'Abgeschlossen',
    'Pending Input' => 'Rückmeldung ausstehend',
    'Deferred' => 'Zurückgestellt',
  ),
  'record_type_display' => 
  array (
    'Accounts' => 'Firmen',
    'Opportunities' => 'Verkaufschancen',
    'Cases' => 'Fälle',
    'Leads' => 'Interessenten',
    'Contacts' => 'Kontakte',
    'ProductTemplates' => 'Produkt',
    'Quotes' => 'Angebote',
    'Bugs' => 'Fehler',
    'Project' => 'Projekte',
    'ProjectTask' => 'Projektaufgaben',
    'Tasks' => 'Aufgaben',
  ),
  'record_type_display_notes' => 
  array (
    'Accounts' => 'Firmen',
    'Contacts' => 'Kontakte',
    'Opportunities' => 'Verkaufschancen',
    'Cases' => 'Fälle',
    'Leads' => 'Interessenten',
    'ProductTemplates' => 'Produkte',
    'Quotes' => 'Angebote',
    'Products' => 'Produkte',
    'Contracts' => 'Verträge',
    'Bugs' => 'Fehler',
    'Emails' => 'E-Mails',
    'Project' => 'Projekte',
    'ProjectTask' => 'Projektaufgaben',
    'Meetings' => 'Meetings',
    'Calls' => 'Anrufe',
  ),
  'product_status_dom' => 
  array (
    'Quotes' => 'angeboten',
    'Orders' => 'beauftrag',
    'Ship' => 'geliefert',
  ),
  'pricing_formula_dom' => 
  array (
    'Fixed' => 'Festpreis',
    'ProfitMargin' => 'Gewinn',
    'PercentageMarkup' => 'Spanne',
    'PercentageDiscount' => 'Rabatt vom Listenpreis',
    'IsList' => 'wie Listenpreis',
  ),
  'product_template_status_dom' => 
  array (
    'Available' => 'verfügbar',
    'Unavailable' => 'nicht verfügbar',
  ),
  'tax_class_dom' => 
  array (
    'Taxable' => 'steuerbar',
    'Non-Taxable' => 'steuerfrei',
  ),
  'support_term_dom' => 
  array (
    '+6 months' => 'Sechs Monate',
    '+1 year' => 'Ein Jahr',
    '+2 years' => 'Zwei Jahre',
  ),
  'quote_type_dom' => 
  array (
    'Quotes' => 'Angebote',
    'Orders' => 'Aufträge',
  ),
  'quote_stage_dom' => 
  array (
    'Draft' => 'Entwurf',
    'Negotiation' => 'Verhandlung',
    'Delivered' => 'Geliefert',
    'On Hold' => 'Rückgestellt',
    'Confirmed' => 'Zugesagt',
    'Closed Accepted' => 'Gewonnen',
    'Closed Lost' => 'Verloren',
    'Closed Dead' => 'Wird nicht realisiert',
  ),
  'layouts_dom' => 
  array (
    'Standard' => 'Angebot',
    'Invoice' => 'Rechnung',
    'Terms' => 'Zahlungskonditionen',
  ),
  'bug_priority_dom' => 
  array (
    'Urgent' => 'Dringend',
    'High' => 'Hoch',
    'Medium' => 'Mittel',
    'Low' => 'Niedrig',
  ),
  'bug_resolution_dom' => 
  array (
    '' => ' ',
    'Accepted' => 'Akzeptiert',
    'Duplicate' => 'Duplizieren',
    'Fixed' => 'fixiert',
    'Out of Date' => 'Abgelaufen',
    'Invalid' => 'Ungültig',
    'Later' => 'Später',
  ),
  'bug_type_dom' => 
  array (
    'Defect' => 'Defekt',
    'Feature' => 'Funktionalität',
  ),
  'campaign_status_dom' => 
  array (
    '' => ' ',
    'Planning' => 'Planung',
    'Active' => 'Aktive',
    'Inactive' => 'Inaktiv',
    'Complete' => 'Abgeschlossen:',
    'In Queue' => 'in Warteschlange',
    'Sending' => 'wird gesendet',
  ),
  'dom_report_types' => 
  array (
    'tabular' => 'Zeilen und Spalten',
    'summary' => 'Summen',
    'detailed_summary' => 'Summe mit Details',
  ),
  'dom_email_types' => 
  array (
    'out' => 'Gesendet:',
    'archived' => 'Archiviert',
    'draft' => 'Entwurf',
    'inbound' => 'Eingehend',
  ),
  'dom_email_status' => 
  array (
    'archived' => 'Archiviert',
    'closed' => 'Abgeschlossen',
    'draft' => 'Entwurf',
    'read' => 'Gelesen',
    'replied' => 'Beantwortet',
    'sent' => 'Gesendet',
    'send_error' => 'Sende-Fehler',
    'unread' => 'Ungelesen',
  ),
  'dom_mailbox_type' => 
  array (
    'pick' => 'Anlegen [Jede]',
    'bug' => 'Neuer Fehler',
    'support' => 'Neuer Fall',
    'contact' => 'Neuer Kontakt',
    'sales' => 'Neuer Interessent',
    'task' => 'Neue Aufgabe',
    'bounce' => 'Nicht zustellbare bearbeiten',
  ),
  'dom_email_distribution' => 
  array (
    '' => ' ',
    'direct' => 'Direkt zuweisen',
    'roundRobin' => 'Umlauf-Verfahren',
    'leastBusy' => 'geringste Auslastung',
  ),
  'dom_email_errors' => 
  array (
    1 => 'Nur einen Benutzer auswählen bei der Zuweisung',
    2 => 'Sie dürfen nur ein ausgeähltes Element zuweisen wenn Sie direkt zuweisen',
  ),
  'dom_email_bool' => 
  array (
    'bool_true' => 'Ja',
    'bool_false' => 'Nein',
  ),
  'dom_int_bool' => 
  array (
    1 => 'Ja',
    0 => 'Nein',
  ),
  'dom_switch_bool' => 
  array (
    'on' => 'Ja',
    'off' => 'Nein',
    '' => ' Nein',
  ),
  'dom_email_link_type' => 
  array (
    '' => ' ',
    'sugar' => 'SugarCRM E-Mail Client',
    'mailto' => 'Externer Mail Client',
  ),
  'schedulers_times_dom' => 
  array (
    'not run' => 'Zeitvorgabe abgelaufen, nicht ausgeführt',
    'ready' => 'Bereit',
    'in progress' => 'In Bearbeitung',
    'failed' => 'Fehlgeschlagen',
    'completed' => 'Abgeschlossen',
    'no curl' => 'Nicht gelaufen: cURL nicht verfügbar',
  ),
  'forecast_schedule_status_dom' => 
  array (
    'Active' => 'Aktiv',
    'Inactive' => 'Inaktiv',
  ),
  'dom_meeting_accept_options' => 
  array (
    'accept' => 'Akzeptiert',
    'decline' => 'Abgelehnt',
    'tentative' => 'Vorläufig',
  ),
  'dom_meeting_accept_status' => 
  array (
    'accept' => 'Akzeptiert',
    'decline' => 'Abgelehnt',
    'tentative' => 'Vorläufig',
    'none' => 'Kein(e)',
  ),
  'wflow_type_dom' => 
  array (
    'Normal' => 'Beim Speichern des Datensatzes',
    'Time' => 'Nach Zeitablauf',
  ),
  'mselect_type_dom' => 
  array (
    'Equals' => 'Gleich',
    'in' => 'ist eines von',
  ),
  'cselect_type_dom' => 
  array (
    'Equals' => 'Gleich',
    'Does not Equal' => 'Ungleich',
  ),
  'dselect_type_dom' => 
  array (
    'Equals' => 'Gleich',
    'Less Than' => 'Kleiner als',
    'More Than' => 'Größer als',
    'Does not Equal' => 'Ungleich',
  ),
  'bselect_type_dom' => 
  array (
    'bool_true' => 'Ja',
    'bool_false' => 'Nein',
  ),
  'bopselect_type_dom' => 
  array (
    'Equals' => 'Gleich',
  ),
  'tselect_type_dom' => 
  array (
    0 => '0 Stunden',
    14440 => '4 Stunden',
    28800 => '8 Stunden',
    43200 => '12 Stunden',
    86400 => '1 Tag',
    172800 => '2 Tage',
    259200 => '3 Tage',
    345600 => '4 Tage',
    432000 => '5 Tage',
    604800 => '1 Woche',
    1209600 => '2 Wochen',
    1814400 => '3 Wochen ',
    2592000 => '30 Tage',
    5184000 => '60 Tage',
    7776000 => '90 Tage',
    10368000 => '120 Tage',
    12960000 => '150 Tage',
    15552000 => '180 Tage',
  ),
  'dtselect_type_dom' => 
  array (
    'More Than' => 'war größer als',
    'Less Than' => 'ist kleiner als',
  ),
  'wflow_source_type_dom' => 
  array (
    'Normal Message' => 'Standard Nachricht',
    'Custom Template' => 'Benutzerdefinierte Vorlage',
    'System Default' => 'System Vorgabe',
  ),
  'wflow_user_type_dom' => 
  array (
    'current_user' => 'Logged-in User',
    'rel_user' => 'Verknüpfte Benutzer',
    'rel_user_custom' => 'Verknüpfte Individualbenutzer',
    'specific_team' => 'Bestimmtes Team',
    'specific_role' => 'Bestimmte Rolle',
    'specific_user' => 'Bestimmte Benutzer',
  ),
  'wflow_array_type_dom' => 
  array (
    'future' => 'Neuer Wert',
    'past' => 'Alter Wert',
  ),
  'wflow_relate_type_dom' => 
  array (
    'Self' => 'Benutzer',
    'Manager' => 'Manager des Benutzers',
  ),
  'wflow_address_type_dom' => 
  array (
    'to' => 'An:',
    'cc' => 'Cc:',
    'bcc' => 'Bcc:',
  ),
  'wflow_address_type_to_only_dom' => 
  array (
    'to' => 'An:',
  ),
  'wflow_action_type_dom' => 
  array (
    'update' => 'Datensatz aktualisieren',
    'update_rel' => 'Verknüpfte Datensätze aktualisieren',
    'new' => 'Neuer Datensatz',
  ),
  'wflow_action_datetime_type_dom' => 
  array (
    'Triggered Date' => 'Zeitgesteuert',
    'Existing Value' => 'bestehender Wert',
  ),
  'wflow_set_type_dom' => 
  array (
    'Basic' => 'Standard Optionen',
    'Advanced' => 'Erweiterte Optionen',
  ),
  'wflow_adv_user_type_dom' => 
  array (
    'assigned_user_id' => 'Benutzer der dem Datensatz zugeordnet ist',
    'modified_user_id' => 'Benutzer der den Datensatz zuletzt geändert hat',
    'created_by' => 'Benutzer der den Datensatz angelegt hat',
    'current_user' => 'eingeloggter Benutzer',
  ),
  'wflow_adv_team_type_dom' => 
  array (
    'team_id' => 'derzeitiges Team des Datensatzes',
    'current_team' => 'Team des eingeloggten Benutzers',
  ),
  'wflow_adv_enum_type_dom' => 
  array (
    'retreat' => 'Dropdown zurückverschieben',
    'advance' => 'Dropdown vorwärtsverschieben',
  ),
  'wflow_record_type_dom' => 
  array (
    'All' => 'Neue und bestehende Einträge',
    'New' => 'nur neue Einträge',
    'Update' => 'nur bestehende Einträge',
  ),
  'wflow_relfilter_type_dom' => 
  array (
    'all' => 'Alle',
    'any' => 'alle zugeordneten',
  ),
  'wflow_fire_order_dom' => 
  array (
    'alerts_actions' => 'Alarm dann Aktionen',
    'actions_alerts' => 'Aktionen dann Alarm',
  ),
  'email_marketing_status_dom' => 
  array (
    '' => ' ',
    'active' => 'Aktive',
    'inactive' => 'Inaktive',
  ),
  'campainglog_target_type_dom' => 
  array (
    'Contacts' => 'Kontakte',
    'Users' => 'Benutzer',
    'Prospects' => 'Zielkontakte',
    'Leads' => 'Interessenten',
  ),
  'contract_status_dom' => 
  array (
    'notstarted' => 'Nicht begonnen',
    'inprogress' => 'In Bearbeitung',
    'signed' => 'Unterzeichnet',
  ),
  'contract_payment_frequency_dom' => 
  array (
    'monthly' => 'Monatlich',
    'quarterly' => 'Quartalsweise',
    'halfyearly' => 'Halbjährlich',
    'yearly' => 'Jährlich',
  ),
  'contract_expiration_notice_dom' => 
  array (
    1 => '1 tag',
    3 => '3 Tage',
    5 => '5  Tage',
    7 => '1 Woche',
    14 => '2 Wochen',
    21 => '3 Wochen',
    31 => '1 Monat',
  ),
);

