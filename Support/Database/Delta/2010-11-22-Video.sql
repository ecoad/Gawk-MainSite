CREATE TABLE "Video"
(
   "Id" serial NOT NULL, 
   "Filename" text NOT NULL, 
   "WallId" text NOT NULL, 
   "DateCreated" timestamp without time zone NOT NULL DEFAULT now(), 
   "SecureId" text NOT NULL,
   CONSTRAINT "Video_Id_pkey" PRIMARY KEY ("Id")
) 
WITH (
  OIDS = FALSE
)
;
GRANT ALL ON TABLE "Video" TO GROUP "WebUserGroup";
GRANT ALL ON TABLE "Video_Id_seq" TO GROUP "WebUserGroup";