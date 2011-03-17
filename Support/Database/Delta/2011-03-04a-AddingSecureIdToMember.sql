ALTER TABLE "Member" ADD COLUMN "SecureId" text;

CREATE INDEX "Member_SecureId_idx"
  ON "Member"
  USING btree
  ("SecureId");