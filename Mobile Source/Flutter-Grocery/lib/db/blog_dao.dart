import 'package:fluttermultigrocery/viewobject/blog.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class BlogDao extends PsDao<Blog> {
  BlogDao._() {
    init(Blog());
  }
  static const String STORE_NAME = 'Blog';
  final String _primaryKey = 'id';

  // Singleton instance
  static final BlogDao _singleton = BlogDao._();

  // Singleton accessor
  static BlogDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(Blog object) {
    return object.id;
  }

  @override
  Filter getFilter(Blog object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
