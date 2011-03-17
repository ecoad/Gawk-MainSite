CREATE TABLE "Rating"
(
   "Id" serial NOT NULL, 
   "VideoSecureId" text NOT NULL,
   "PositiveRating" text NOT NULL,  
   "DateCreated" timestamp without time zone NOT NULL DEFAULT now(), 
   "IpAddress" text,
   CONSTRAINT "Rating_Id_pkey" PRIMARY KEY ("Id")
) 
WITH (
  OIDS = FALSE
)
;
GRANT ALL ON TABLE "Rating" TO GROUP "WebUserGroup";
GRANT ALL ON TABLE "Rating_Id_seq" TO GROUP "WebUserGroup";