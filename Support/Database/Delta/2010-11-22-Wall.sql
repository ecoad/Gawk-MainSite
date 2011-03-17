CREATE TABLE "Wall"
(
   "Id" serial NOT NULL,
   "SecureId" text NOT NULL,   
   "DateCreated" timestamp without time zone NOT NULL DEFAULT now(), 
   CONSTRAINT "Wall_Id_pkey" PRIMARY KEY ("Id")
) 
WITH (
  OIDS = FALSE
)
;
GRANT ALL ON TABLE "Wall" TO GROUP "WebUserGroup";
GRANT ALL ON TABLE "Wall_Id_seq" TO GROUP "WebUserGroup";