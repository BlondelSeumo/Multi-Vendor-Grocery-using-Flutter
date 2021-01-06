import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';

class UserDao extends PsDao<User> {
  UserDao._() {
    init(User());
  }

  static const String STORE_NAME = 'User';
  final String _primaryKey = 'user_id';

  // Singleton instance
  static final UserDao _singleton = UserDao._();

  // Singleton accessor
  static UserDao get instance => _singleton;

  @override
  String getPrimaryKey(User object) {
    return object.userId;
  }

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  Filter getFilter(User object) {
    return Filter.equals(_primaryKey, object.userId);
  }
}
