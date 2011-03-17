CREATE TABLE "StaticContent"
(
  "Id" serial NOT NULL,
  "Handle" text,
  "Title" text,
  "Body" text,
  "DateCreated" timestamp without time zone NOT NULL DEFAULT now(),
  CONSTRAINT "StaticContent_Id" PRIMARY KEY ("Id")
)
WITH (OIDS=FALSE);
ALTER TABLE "StaticContent" OWNER TO postgres;
GRANT ALL ON TABLE "StaticContent" TO postgres;
GRANT ALL ON TABLE "StaticContent" TO "WebUserGroup";

CREATE INDEX "StaticContent_Id_idx"
  ON "StaticContent"
  USING btree
  ("Id");

GRANT ALL ON TABLE "StaticContent_Id_seq" TO postgres;
GRANT ALL ON TABLE "StaticContent_Id_seq" TO "WebUserGroup";

INSERT INTO "SecurityResource"("Id", "Name", "Description") VALUES (77,'Static Content Admin','Enables Administrator to edit Channels.');
INSERT INTO "SecurityGroupToSecurityResource"( "Id", "SecurityGroupId", "SecurityResourceName") VALUES (283,3,'Static Content Admin');