use document_tracking_system;
CREATE VIEW `Incoming_Doc_Log` AS
select distinct doc_log.doc_id as ID,
	concat('IN', convert(doc_log.doc_id, char(5))) as Incoming_ID,
	doc_log.dateReceived_Transmitted,
	doc_log.sender_recipient,
	doc_code_list.doc_code as doc_type,
	doc.reference_date,
	doc_log.remarks_particulars
from 
	doc_log, doc_code_list, doc, doc_info
where
	doc_log.doc_id = doc_info.id and
    doc_log.doc_id = doc.id and
    doc_info.id = doc.id and
    doc_info.doc_code_id = doc_code_list.doc_code_id and
    doc_log.status='IN' and
	time_stamp = (SELECT MAX(time_stamp) FROM doc_log s2 WHERE doc_log.doc_ID = s2.doc_ID and status='IN');
