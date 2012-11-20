class Bb < ActiveRecord::Base
  attr_accessible :package_id, :email, :name, :content
  belongs_to :package
  after_create :update_package

  def update_package
    unless self.email == 'sage'
      self.package.updated_at = Time_now
      self.package.save
    end
  end
end
