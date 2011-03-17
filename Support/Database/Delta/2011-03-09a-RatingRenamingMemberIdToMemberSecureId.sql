ALTER TABLE "MemberRating" DROP COLUMN "MemberId";
ALTER TABLE "MemberRating" ADD COLUMN "MemberSecureId" text;

CREATE INDEX "Rating_MemberSecureId_idx"
  ON "MemberRating"
  USING btree
  ("MemberSecureId");