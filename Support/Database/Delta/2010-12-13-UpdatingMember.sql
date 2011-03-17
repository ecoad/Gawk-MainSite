ALTER TABLE "Member" ALTER COLUMN "EmailAddress" DROP NOT NULL;
ALTER TABLE "Member" ALTER COLUMN "Alias" DROP NOT NULL;
ALTER TABLE "Member" ALTER COLUMN "Password" DROP NOT NULL;
ALTER TABLE "Member" ADD COLUMN "FbId" text;
ALTER TABLE "Member" ADD COLUMN "GawksPublic" boolean DEFAULT false;
ALTER TABLE "Member" ADD COLUMN "GawksFavouritePublic" boolean DEFAULT false;
ALTER TABLE "Member" ADD COLUMN "Twitter" text;