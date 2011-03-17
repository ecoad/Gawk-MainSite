CREATE TABLE "MemberFriend"
(
	"Id" serial NOT NULL,
	"MemberId" integer NOT NULL,
	"FriendId" integer NOT NULL,
	"DateCreated" timestamp without time zone DEFAULT now(), 
	CONSTRAINT "MemberFriend_Id_pkey" PRIMARY KEY ("Id")
) 
WITH (
  OIDS = FALSE
)
;
GRANT ALL ON TABLE "MemberFriend" TO GROUP "WebUserGroup";
GRANT ALL ON TABLE "MemberFriend_Id_seq" TO GROUP "WebUserGroup";