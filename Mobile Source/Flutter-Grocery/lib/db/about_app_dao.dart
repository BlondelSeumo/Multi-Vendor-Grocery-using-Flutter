import 'package:fluttermultigrocery/db/common/ps_dao.dart';
import 'package:fluttermultigrocery/viewobject/about_app.dart';
import 'package:sembast/sembast.dart';

class AboutAppDao extends PsDao<AboutApp> {
  AboutAppDao._() {
    init(AboutApp());
  }
  static const String STORE_NAME = 'AboutApp';
  final String _primaryKey = 'about_id';

  // Singleton instance
  static final AboutAppDao _singleton = AboutAppDao._();

  // Singleton accessor
  static AboutAppDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(AboutApp object) {
    return object.aboutId;
  }

  @override
  Filter getFilter(AboutApp object) {
    return Filter.equals(_primaryKey, object.aboutId);
  }
}
