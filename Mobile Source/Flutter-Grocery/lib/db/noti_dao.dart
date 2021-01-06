import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';
import 'package:fluttermultigrocery/viewobject/noti.dart';

class NotiDao extends PsDao<Noti> {
  NotiDao._() {
    init(Noti());
  }

  static const String STORE_NAME = 'Noti';
  final String _primaryKey = 'id';
  // Singleton instance
  static final NotiDao _singleton = NotiDao._();

  // Singleton accessor
  static NotiDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(Noti object) {
    return object.id;
  }

  @override
  Filter getFilter(Noti object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
