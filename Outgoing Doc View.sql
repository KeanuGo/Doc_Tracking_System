use document_tracking_system;
CREATE VIEW `Outgoing_Doc_Log` AS
select doc.id,
	concat('OUT', convert(doc_log.doc_id, CHAR(5))) as Outgoing_ID,
	incoming_doc_log.Incoming_ID,
	doc_log.dateReceived_Transmitted,
	doc_log.sender_recipient,
	doc_code_list.doc_code,
	doc.reference_date,
	doc_log.remarks_particulars
from 
	doc_log, doc_code_list, doc, doc_info, incoming_doc_log
where
	incoming_doc_log.ID = doc_log.doc_id and
    incoming_doc_log.ID = doc.id and
    incoming_doc_log.ID = doc_info.id and
	doc.id = doc_info.id and
    doc.id = doc_log.doc_id and
    doc_log.doc_id = doc_info.id and
    doc_info.doc_code_id = doc_code_list.doc_code_id and
    doc_log.status='OUT';
    