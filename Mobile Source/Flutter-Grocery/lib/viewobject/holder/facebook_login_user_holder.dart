import 'package:firebase_auth/firebase_auth.dart';

class FacebookLoginUserHolder {
  FacebookLoginUserHolder(this.firebaseUser, this.facebookUser);
  User firebaseUser;
  dynamic facebookUser;
}
