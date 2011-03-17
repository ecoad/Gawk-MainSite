CREATE TABLE "MemberWallBookmark"
(
	"Id" serial NOT NULL,
	"WallId" integer NOT NULL,
	"MemberId" integer NOT NULL,
	"DateCreated" timestamp without time zone DEFAULT now(), 
	CONSTRAINT "MemberWallBookmark_Id_pkey" PRIMARY KEY ("Id")
) 
WITH (
  OIDS = FALSE
)
;
GRANT ALL ON TABLE "MemberWallBookmark" TO GROUP "WebUserGroup";
GRANT ALL ON TABLE "MemberWallBookmark_Id_seq" TO GROUP "WebUserGroup";