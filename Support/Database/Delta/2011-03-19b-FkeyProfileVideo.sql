ALTER TABLE "Member"
  DROP CONSTRAINT "Member_ProfileVideoSecureId_fkey";
ALTER TABLE "Member"
  ADD CONSTRAINT "Member_ProfileVideoSecureId_fkey" FOREIGN KEY ("ProfileVideoSecureId")
      REFERENCES "Video" ("SecureId") MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE SET NULL;
