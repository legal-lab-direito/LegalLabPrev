SELECT setval('category_id_seq', coalesce(max(id),0) + 1, false) FROM category;
SELECT setval('lead_id_seq', coalesce(max(id),0) + 1, false) FROM lead;
SELECT setval('possible_answers_id_seq', coalesce(max(id),0) + 1, false) FROM possible_answers;
SELECT setval('questions_id_seq', coalesce(max(id),0) + 1, false) FROM questions;
SELECT setval('subject_id_seq', coalesce(max(id),0) + 1, false) FROM subject;
SELECT setval('type_id_seq', coalesce(max(id),0) + 1, false) FROM type;