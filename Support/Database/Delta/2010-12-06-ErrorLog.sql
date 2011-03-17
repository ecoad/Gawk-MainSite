CREATE TABLE "ErrorLog"
(
   "Id" serial NOT NULL, 
   "WallId" text NOT NULL,
   "LogData" text NOT NULL,  
   "DateCreated" timestamp without time zone NOT NULL DEFAULT now(), 
   "IpAddress" text,
   CONSTRAINT "ErrorLog_Id_pkey" PRIMARY KEY ("Id")
) 
WITH (
  OIDS = FALSE
)
;
GRANT ALL ON TABLE "ErrorLog" TO GROUP "WebUserGroup";
GRANT ALL ON TABLE "ErrorLog_Id_seq" TO GROUP "WebUserGroup";