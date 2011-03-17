ALTER TABLE "Video" DROP COLUMN "MemberId";
ALTER TABLE "Video" ADD COLUMN "MemberSecureId" text;

CREATE INDEX "Video_MemberSecureId_idx"
  ON "Video"
  USING btree
  ("MemberSecureId");
  
ALTER TABLE "Wall" DROP COLUMN "MemberId";
ALTER TABLE "Wall" ADD COLUMN "MemberSecureId" text;

CREATE INDEX "Wall_MemberSecureId_idx"
  ON "Wall"
  USING btree
  ("MemberSecureId");