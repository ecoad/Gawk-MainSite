ALTER TABLE "Video" DROP COLUMN "AuthorId";
ALTER TABLE "Video" ADD COLUMN "MemberId" integer;
ALTER TABLE "Video" ADD CONSTRAINT "Video_SecureId_unique" UNIQUE ("SecureId");

CREATE TABLE "MemberRating"
(
  "Id" serial NOT NULL,
  "VideoSecureId" text NOT NULL,
  "PositiveRating" text NOT NULL,
  "DateCreated" timestamp without time zone NOT NULL DEFAULT now(),
  "IpAddress" text,
  "MemberId" integer,
  CONSTRAINT "MemberRating_Id_pkey" PRIMARY KEY ("Id"),
  CONSTRAINT "MemberRating_MemberId_Fkey" FOREIGN KEY ("MemberId")
      REFERENCES "Member" ("Id") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT "MemberRating_VideoSecureId_fkey" FOREIGN KEY ("VideoSecureId")
      REFERENCES "Video" ("SecureId") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE "MemberRating" OWNER TO postgres;
GRANT ALL ON TABLE "MemberRating" TO postgres;
GRANT ALL ON TABLE "MemberRating" TO "WebUserGroup";

CREATE INDEX "Rating_VideoId_Idx"
   ON "MemberRating" ("VideoSecureId" ASC NULLS LAST);

CREATE INDEX "MemberRating_MemberId_Idx"
   ON "MemberRating" ("MemberId" ASC NULLS LAST);