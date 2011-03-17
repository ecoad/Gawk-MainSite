ALTER TABLE "Video" ADD COLUMN "Hash" text;

CREATE INDEX "Video_Hash_idx"
  ON "Video"
  USING btree
  ("Hash");