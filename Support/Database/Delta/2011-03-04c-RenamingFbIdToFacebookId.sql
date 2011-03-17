ALTER TABLE "MemberFriend" DROP COLUMN "FriendFbId";
ALTER TABLE "MemberFriend" ADD COLUMN "FriendFacebookId" integer;

CREATE INDEX "MemberFriend_FriendFacebookId_idx"
  ON "MemberFriend"
  USING btree
  ("FriendFacebookId");