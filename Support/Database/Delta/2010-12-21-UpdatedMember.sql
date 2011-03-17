ALTER TABLE "Member" DROP COLUMN "GawksPublic";
ALTER TABLE "Member" ADD COLUMN "GawksPublic" integer;

ALTER TABLE "Member" DROP COLUMN "GawksFavouritePublic";
ALTER TABLE "Member" ADD COLUMN "GawksFavouritePublic" integer;