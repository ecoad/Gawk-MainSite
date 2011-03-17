ALTER TABLE "Wall" ADD COLUMN "Description" text;
ALTER TABLE "Wall" ADD COLUMN "Url" text;

CREATE INDEX "Wall_Url_idx"
  ON "Wall"
  USING btree
  ("Url");
  
DROP INDEX "Member_Token_idx";
CREATE INDEX "Member_Token_idx"
  ON "Member"
  USING btree
  ("Token");