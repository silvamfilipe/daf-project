create view questions_list as
select q.id as questionId, u.id as userId, u.name, u.email, q.title, q.date_published as datePublished,
       qt.tags, a.answers
from questions as q
       left join users as u on u.id = q.user_id
       left join question_tag_list as qt on qt.question_id = q.id
       left join question_answers as a on a.question_id = q.id;

create view question_answers as
select question_id, count(question_id) answers from answers group by question_id;

create view question_tag_list as
select q.id as question_id, GROUP_CONCAT(t.description SEPARATOR ', ') as tags
from questions as q
       left join question_tags as qt on qt.question_id = q.id
       left join tags as t on t.id = qt.tag_id
group by q.id;