ALTER TABLE "MemberWallBookmark" DROP COLUMN "MemberId";
ALTER TABLE "MemberWallBookmark" ADD COLUMN "MemberSecureId" text;

CREATE INDEX "MemberWallBookmark_MemberSecureId_idx"
  ON "MemberWallBookmark"
  USING btree
  ("MemberSecureId");
  
ALTER TABLE "MemberWallBookmark" DROP COLUMN "WallId";
ALTER TABLE "MemberWallBookmark" ADD COLUMN "WallSecureId" text;

CREATE INDEX "MemberWallBookmark_WallSecureId_idx"
  ON "MemberWallBookmark"
  USING btree
  ("WallSecureId");