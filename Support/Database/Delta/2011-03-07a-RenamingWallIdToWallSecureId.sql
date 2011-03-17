ALTER TABLE "Video" DROP COLUMN "WallId";
ALTER TABLE "Video" ADD COLUMN "WallSecureId" text;

CREATE INDEX "Video_WallSecureId_idx"
  ON "Video"
  USING btree
  ("WallSecureId");