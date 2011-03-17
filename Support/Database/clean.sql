DELETE FROM "Note";
DELETE FROM "Address";
DELETE FROM "Article";
DELETE FROM "BlogEntry";
DELETE FROM "Blog";
DELETE FROM "Comment";
DELETE FROM "FeedbackNote";
DELETE FROM "Feedback";
DELETE FROM "Photo";
DELETE FROM "Setting";
DELETE FROM "TagToData";
DELETE FROM "Tag";
DELETE FROM "TourDate";
DELETE FROM "TourDetail";
DELETE FROM "Video";
DELETE FROM "Binary";

SELECT setval('public."Note_Id_seq"', 1, true);
SELECT setval('public."Address_Id_seq"', 1, true);
SELECT setval('public."Article_Id_seq"', 1, true);
SELECT setval('public."Blog_Id_seq"', 1, true);
SELECT setval('public."Comment_Id_seq"', 1, true);
SELECT setval('public."Feedback_Id_seq"', 1, true);
SELECT setval('public."FeedbackNote_Id_seq"', 1, true);
SELECT setval('public."Photo_Id_seq"', 1, true);
SELECT setval('public."Setting_Id_seq"', 1, true);
SELECT setval('public."TagToData_Id_seq"', 1, true);
SELECT setval('public."Tag_Id_seq"', 1, true);
SELECT setval('public."TourDate_Id_seq"', 1, true);
SELECT setval('public."TourDetail_Id_seq"', 1, true);
SELECT setval('public."Video_Id_seq"', 1, true);
SELECT setval('public."Binary_Id_seq"', 1, true);



--DELETE FROM "Country";
--DELETE FROM "Member";
--DELETE FROM "MemberToAddress";
--DELETE FROM "MemberToSecurityGroup";
--DELETE FROM "SecurityGroup";
--DELETE FROM "SecurityGroupToSecurityResource";
--DELETE FROM "SecurityResource";